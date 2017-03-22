select r.servicenumber as "Service Number", 
r.routenumber as "Route Number", 
r.startbusstop as "First Stop", 
b1.locationdesc as "First Stop Description", 
r.endbusstop as "Last Stop", 
b2.locationdesc as "Last Stop Description"
from route r, bus_stop b1, bus_stop b2 where r.startbusstop=b1.stopnumber and r.endbusstop=b2.stopnumber order by servicenumber*1; 

select
bs.stopnumber as "Stop Code",
bs.locationdesc as "Location Description",
bs.address as "Address",
if(ts.stopnumber is null, 'No', 'Yes') as "Terminus?",
temp.dcount as "Number of routes served"
from 
bus_stop bs left outer join terminus ts on bs.stopnumber = ts.stopnumber left outer join (select stopnumber, count(distinct servicenumber, routenumber) as "dcount" from bus_route br group by stopnumber) as temp on temp.stopnumber=bs.stopnumber
order by 5 desc, bs.stopnumber*1; 

select drivername as "Driver Name", 
licensenumber as "License Number", 
datecertified as "Date certified", 
busplate as "Bus plate", 
servicenumber as "Service Number", 
routenumber as "Route Number" 
from driver d 
left outer join trip p on d.staffID=p.driver and 
cancelled=0 and 
str_to_date(CONCAT(tripdate, ' ', triptime),'%Y-%m-%d %H:%i:%s') between str_to_date('2016-09-21 09:30:00', '%Y-%m-%d %H:%i:%s') and str_to_date('2016-09-21 12:30:00', '%Y-%m-%d %H:%i:%s') 
order by d.drivername, d.licensenumber;

select 
t2.servicenumber as "Service Number",
t2.routenumber as "Route Number",
r.remark as "Remark",
count(t2.cancelled) as "Total Cancelled Trips"
from 
trip t2 inner join route r on t2.routenumber = r.routenumber and t2.servicenumber = r.servicenumber
where 
t2.cancelled = 1
group by t2.servicenumber, t2.routenumber
having count(t2.cancelled) = (
	select 
	count(t.cancelled) as "c_count"
	from 
	trip t 
	where 
	t.cancelled = 1
	group by t.servicenumber, t.routenumber
	order by c_count desc limit 1);