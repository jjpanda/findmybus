use  findmybus;

delete from trip;
delete from driver_offdays;
delete from driver;
delete from bus;
delete from stop_search;
delete from service_search;
delete from week_period;
delete from non_terminus;
delete from terminus;
delete from bus_route;
delete from route;
delete from bus_stop;
delete from service;
commit;

LOAD DATA INFILE 'C:/data/services.txt' INTO TABLE service FIELDS TERMINATED BY ','   LINES TERMINATED BY '\r\n'   IGNORE 1 LINES;

LOAD DATA INFILE 'C:/data/bus-stops.txt' INTO TABLE bus_stop FIELDS TERMINATED BY '\t'   LINES TERMINATED BY '\r\n'   IGNORE 1 LINES;

LOAD DATA INFILE 'C:/data/route.txt' INTO TABLE route FIELDS TERMINATED BY '\t'   LINES TERMINATED BY '\r\n'   IGNORE 1 LINES;

LOAD DATA INFILE 'C:/data/bus-route.txt' INTO TABLE bus_route FIELDS TERMINATED BY '\t'   LINES TERMINATED BY '\r\n'   IGNORE 1 LINES;

LOAD DATA INFILE 'C:/data/terminus.txt' INTO TABLE terminus FIELDS TERMINATED BY '\t'   LINES TERMINATED BY '\r\n'   IGNORE 1 LINES;

LOAD DATA INFILE 'C:/data/non-terminus.txt' INTO TABLE non_terminus FIELDS TERMINATED BY '\t'   LINES TERMINATED BY '\r\n'   IGNORE 1 LINES;

LOAD DATA INFILE 'C:/data/week-period.txt' INTO TABLE week_period FIELDS TERMINATED BY '\t'   LINES TERMINATED BY '\r\n'   IGNORE 1 LINES;

LOAD DATA INFILE 'C:/data/service-search.txt' INTO TABLE service_search FIELDS TERMINATED BY '\t'   LINES TERMINATED BY '\r\n'   IGNORE 1 LINES;

LOAD DATA INFILE 'C:/data/stop-search.txt' INTO TABLE stop_search FIELDS TERMINATED BY '\t'   LINES TERMINATED BY '\r\n'   IGNORE 1 LINES;

LOAD DATA INFILE 'C:/data/bus.txt' INTO TABLE bus FIELDS TERMINATED BY '\t'   LINES TERMINATED BY '\r\n'   IGNORE 1 LINES;

LOAD DATA INFILE 'C:/data/driver.txt' INTO TABLE driver FIELDS TERMINATED BY '\t'   LINES TERMINATED BY '\r\n'   IGNORE 1 LINES;

LOAD DATA INFILE 'C:/data/driver-offdays.txt' INTO TABLE driver_offdays FIELDS TERMINATED BY '\t'   LINES TERMINATED BY '\r\n'   IGNORE 1 LINES;

LOAD DATA INFILE 'C:/data/trip.txt' INTO TABLE trip FIELDS TERMINATED BY '\t'   LINES TERMINATED BY '\n'   IGNORE 1 LINES;


