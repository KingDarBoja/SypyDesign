# sypy_design
Codes for making a dynamic webpage with PHP + MariaDB + Python for vehicle tracking using Syrus 3G device and Amazon Web services.

The main php file is called index.php which connect to the MariaDB database (Amazon Web Services - RDS) located at the cloud. It refresh the table content after a time interval in order to update the longitude, latitude and time stamp of tracked object (in this case, the Syrus 3G inside a vehicle).

The Sniffer code (.py extension) will registers a specific port (UDP Port) and performs processing of the information received in order to send such information (latitude, longitude and time stamp) to the database.
