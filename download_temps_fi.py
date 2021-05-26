import os
import gmaps
import datetime as dt
from pprint import pprint as pp

from fmiopendata.wfs import download_stored_query
import saatietue

# Retrieve the latest hour of data from a bounding box
end_time = dt.datetime.utcnow()
start_time = end_time - dt.timedelta(hours=1)
# Convert times to properly formatted strings
start_time = start_time.isoformat(timespec="seconds") + "Z"
# -> 2020-07-07T12:00:00Z
end_time = end_time.isoformat(timespec="seconds") + "Z"
# -> 2020-07-07T13:00:00Z

obs = download_stored_query("fmi::observations::weather::multipointcoverage",
                            args=["bbox=18,55,35,75",
                                  "starttime=" + start_time,
                                  "endtime=" + end_time])

def parse_name_data(dataIN):
    dataOUT = {}
    #pp(dataIN)
    
    for dval in dataIN.items():
        ddkey, ddval = dval
        for dataLoc in ddval:
            dataMeasurements = ddval[dataLoc]
            dataOUT[dataLoc] = dataMeasurements
            print("Paikka: {} -> {}\n".format(dataLoc, dataMeasurements))

    return dataOUT

name2mapdata = {} # nimi -> { mapin luonti tietoja }
name2loc = {}     # nimi -> lokaatio tieto
loc2name = obs._location2name
name2data = parse_name_data(obs.data)

#pp(loc2name)


def plot(fig, latlon, info, zoom=10, map_type='ROADMAP'):
    information_box_template = """
<table>
    <tr>
        <td colspan="3">{name}</td>
    </tr>
    <tr>
        <td>{temp} C</td>
        <td>;nbsp&</td>
        <td>{windSpeed} m/s ({windDirection} deg)</td>
    </tr>
    <tr>
        <td><img src="{tempUrl}" /></td>
        <td>;nbsp&</td>
        <td><img src="{windDirectionUrl}" /></td>
    </tr>
</table>
"""
    marker_info = information_box_template.format(**info)

    loc = [ info['location'], ]

    pp(loc)

    marker_layer = gmaps.marker_layer(loc, info_box_content=marker_info)

    fig.add_layer(marker_layer)

gmaps.configure(api_key=os.environ["GMAPS_API_KEY"])
fig = gmaps.figure()



for locItem in loc2name:
    locName = loc2name[locItem]
    currentdata = name2data[locName]

    pp(currentdata)
#    tempID = 'Air temperature'
#    temp = currentdata[tempID]

#    windSPDID = 'Wind speed'
#    windSpeed = currentdata[windSPDID]

#    windDirectionID = 'Wind direction'
#    windDirection = currentdata[windSPDID]
    
        
#    n2dobj = { 'name': locName, 'location': locItem, 'temp': temp, 
#            'windSpeed': windSpeed, 'windDirection': windDirection,
#            'tempUrl': None, 'windDirectionUrl': None }
    
#    name2loc[locName] = locItem
#    name2mapdata[locName] = n2dobj
    


pp(name2loc)

fig

#pp(name2data)

#meta = obs.location_metadata

#pp(meta)