use findmybus;

#a:

select
r.servicenumber as "Service Number",
r.routenumber as "Route Number",
r.startbusstop as "First Stop",
(select locationdesc from bus_stop bs where bs.stopnumber = r.startbusstop) as "First Stop Description",
r.endbusstop as "Last Stop",
(select locationdesc from bus_stop bs where bs.stopnumber = r.endbusstop) as "Last Stop Description"
from
route r left join bus_route br on br.servicenumber = r.servicenumber and r.routenumber = br.routenumber
where br.stoporder = 1
order by r.servicenumber * 1;

#b:

select
bs.stopnumber as "Stop Code",
bs.locationdesc as "Location Description",
bs.address as "Address",
if(ts.stopnumber is null, 'No', 'Yes') as "Terminus?",
(select count(distinct servicenumber, routenumber) as "dcount" from bus_route br where br.stopnumber = bs.stopnumber) as "Number of routes served"
from 
bus_stop bs left join terminus ts on bs.stopnumber = ts.stopnumber
order by 5 desc, bs.stopnumber*1;

#c:

select
d.drivername as "Driver Name",
d.licensenumber as "License Number",
d.datecertified as "Date certified",
if(t.cancelled = '1', NULL, t.busplate) as "Bus plate",
if(t.cancelled = '1', NULL, t.servicenumber) as "Service Number",
if(t.cancelled = '1', NULL, t.routenumber) as "Route Number"
from 
driver d left join trip t on d.staffid = t.driver
where 
t.tripdate between '2016-09-21' and '2016-09-21' and
t.triptime between '09:00:00' and '23:59:00' 
order by d.drivername, d.licensenumber ;

#d:

select 
t2.servicenumber as "Service Number",
t2.routenumber as "Route Number",
r.remark as "Remark",
count(t2.cancelled) as "Total Cancelled Trips"
from 
trip t2 left join route r on t2.routenumber = r.routenumber and t2.servicenumber = r.servicenumber
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




