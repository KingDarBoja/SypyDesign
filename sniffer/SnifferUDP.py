import socket
import time

# Syrus Information / raw_data: >XXXAABBBBCDDDDDEEEFFFFFGGGGHHHHHIIIJJJKL;ID=357330051004711<
# Syrus Information / raw data: 01234567890123456789012345678901234567890;ID=357330051004711<
# El mensaje que se recibe debe filtrarse (Eliminar "Qualifier, Event Command, and ID information")
# AA: Event index. Range 0-99.
# BBBB: Number of weeks since 00:00 AM January 6, 1980.
# C: Day of week. From 0 to 6 where 0 is Sunday.
# DDDDD: Time of the generated report. Seconds since 00:00 of the current date.
# EEEFFFFF: WGS-84 Latitude. It does include the sign: Positive for north. EEE represents a value in degrees and FFFFF parts of a degree in decimals.
# GGGGHHHHH: WGS-84 Longitude. It does include the sign: Positive for east. GGGG represents a value in degrees and HHHHH parts of a degree in decimals.
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

# Formato de los datos para visualización
# Formato de encabezados para tener seguimiento de los datos (Reportes)


def main():
    # Create a TCP/IP socket
    sock = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
    HOST = socket.gethostbyname(socket.gethostname())
    PORT = 10256
    # Bind the socket to the port
    server_address = (HOST, PORT)
    print('Inicializando en Host IPV4 %s Puerto %s' % server_address)
    sock.bind(server_address)

    while True:
        print("Connected")
        try:
            while True:
                raw_data, addr = sock.recvfrom(65535)
                save_data = str(raw_data)[1:]
                # Formato para discriminar Latitud y Longitud
                if raw_data:
                    print('recibido ' + save_data)
                    op, evento, fecha, lat, lon = obtMsg(raw_data);
                    if op:
                        print('Evento: ' + str(evento) + ', ' + 'la latitud es: ' + str(lat) + ' y la longitud es: ' + lon)
                        print('Fecha del dato: ' + fecha)
                    else:
                        print(" Mensaje Ignorado ")
                else:
                    break
        finally:
            print("No se estan recibiendo más datos")


def obtMsg(d):
    # Discrimina entre el REV y RPV
    if d[0:4] == ">REV":
        op = True
        # Se utilizara para imprimir datos (como confirmación)
        evento = int(d[4:6])
        # Se almacenan los index de eventos
        fecha = obtFecha(d[6:10], d[10], d[11:16])
        # Se almacenan las fechas como un string (de una función que le hace tratamiento)
        # Coordenadas
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

def obtFecha(sem,dia,hora):
    seg = sem * 7 * 24 * 60 * 60 + (dia + 3657) * 24 * 60 * 60 + hora + 5 * 60 * 60
    # Transforma el numero (en segundos) a un formato de fecha especificado por los %b %d %Y %M %S
    # (Vease https://docs.python.org/2/library/time.html)
    t = time.mktime(seg)
    fecha = time.strftime("%b %d %Y %H:%M:%S", time.localtime(t))
    return fecha

main()