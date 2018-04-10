# SyPy Design
Dynamic webpage with PHP + SQL + Python for vehicle tracking using Syrus 3G device.

The main php file is called index.php which connect to the provided database (can be remote or local). It refresh the table content after a time interval in order to update the longitude, latitude and time stamp of tracked object (in this case, the Syrus 3G inside a vehicle).

The "sniffer" script (.py extension) will check specified UDP port and perform processing at received data in order to send information as latitude, longitude and timestamp to the database.

The libraries used at the python script, generated using [pipreqs](https://github.com/bndr/pipreqs):

- pendulum==1.4.4
- SQLAlchemy==1.2.6
