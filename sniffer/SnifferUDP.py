import socket
import pendulum
from sqlalchemy import (MetaData, create_engine, Table,
                        Column, String, Integer, insert)

# ******* Message data from Syrus explained. *******
# Syrus raw data: >XXXAABBBBCDDDDDEEEFFFFFGGGGHHHHHIIIJJJKL;ID=357330051004711<
# Received message must be filtered (Remove "Qualifier, Event Command, ID")
# AA: Event index. Range 0-99.
# BBBB: Number of weeks since 00:00 AM January 6, 1980.
# C: Day of week. From 0 to 6 where 0 is Sunday.
# DDDDD: Time of the generated report. Seconds since 00:00 of the current date.
# EEEFFFFF: WGS-84 Latitude. It does include the sign: Positive for north.
# EEE represents a value in degrees and FFFFF parts of a degree in decimals.
# GGGGHHHHH: WGS-84 Longitude. It does include the sign: Positive for east.
# GGGG represents a value in degrees and HHHHH parts of a degree in decimals.
# III: Vehicle velocity in mph.
# JJJ: Vehicle heading, in degrees from North increasing eastwardly.
# K: Position fix mode:
# 0: 2D GPS
# 1: 3D GPS
# 2: 2D DGPS
# 3: 3D DGPS
# 9: Unknown
# L: Age of data used for the report:
# 0: Not available
# 1: Older than 10 seconds
# 2: Fresh, less than 10 seconds
# 9: GPS Failure

# Database name
DB_NAME = 'sypydb'

# Definition of table names inside database DB_NAME
TABLES = {}

# Connect variables.
TABLE_NAME = 'localiz_1'
HOST_NAME = 'localhost'
PORT = 10250
USER_NAME = 'sypy_design'
PASSWORD = 'sypy_1234'

# Create database using pymysql dialect (MySQL)
engine = create_engine('mysql+pymysql://{}:{}}>@{}:{}/{}'
                       .format(USER_NAME, PASSWORD, HOST_NAME, PORT, DB_NAME))
connection = engine.connect()
metadata = MetaData()

vehicle_table = Table(TABLE_NAME, metadata,
                      Column('id', Integer(), unique=True),
                      Column('latitud', String(15), nullable=False),
                      Column('longitud', String(15), nullable=False),
                      Column('tiempo', String(22), unique=True)
                      )

metadata.create_all(engine)


def update_table(sock):
    '''Connect and update values in database using sock argument.'''
    # Get the raw_data plus address (tuple).
    raw_data, addr = sock.recvfrom(65535)
    # Split latitude and longitude from save_data
    if raw_data:
        op, evento, fecha, lat, lon = obtMsg(str(raw_data)[2:])
        # Check state of op
        if op:
            print('Event: {}, Latitude: {} - Longitude: {}'.
                  format(evento, lat, lon))
            print('Datetime: ' + fecha)
            # Insert statement to insert a record into vehicle_table
            stmt = insert(vehicle_table).values(latitud=lat, longitud=lon,
                                                tiempo=fecha)
            # Execute the statement via the connection
            connection.execute(stmt)

        else:
            print("\n{} \nMensaje Ignorado\n{}".format('*'*20, '*'*20))
    else:
        return False


def obtMsg(d):
    # Differentiate between REV and RPV
    if d[0:4] == ">REV":
        op = True
        # This variable is gonna be used as confirmation message.
        evento = int(d[4:6])
        # Store event history index as timestamp
        fecha = obtFecha(d[6:10], d[10], d[11:16])
        # Store coordinates (lat, lon) as string and check sign.
        lat = float(d[17:19]) + (float(d[19:24]) / 100000)
        if d[16] == "-":
            lat = -lat
        lon = float(d[25:28]) + (float(d[28:33]) / 100000)
        if d[24] == "-":
            lon = -lon
    else:
        op = False
        evento = 0
        fecha = ' '
        lat = 0
        lon = 0
    return op, evento, fecha, lat, lon


def obtFecha(sem, dia, hora):
    # Transform all dates into seconds: timestamp_val
    timestamp_val = int(sem)*604800 + int(dia)*86400 + int(hora)*3600
    # Transform timestamp (timestamp_val) into Pendulum instance
    # at defined timezone (timezone_val) and applies datetime method
    # to get output like '1969-12-31 23:59:59'
    timezone_val = 'America/Bogota'
    fecha = pendulum.from_timestamp(timestamp_val,
                                    timezone_val).to_datetime_string()
    return fecha


def main():
    # Create a TCP/IP socket to scan
    sock = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
    sock_host = socket.gethostbyname(socket.gethostname())
    sock_port = 10257
    # Bind the socket to the port
    server_address = (sock_host, sock_port)
    print('Inicializando en Host IPV4 {} Puerto {}'.format(server_address))
    sock.bind(server_address)
    if sock.bind(server_address):
        print('Socket binding successful.')
        data_received = True
    else:
        print('socket binding failed.')
        data_received = False

    while data_received:
        try:
            data_received = update_table(sock)
        finally:
            connection.close()
            print("No more data being received. \nConnection Closed")


main()
