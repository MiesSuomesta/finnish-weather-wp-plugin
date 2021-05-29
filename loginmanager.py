import traceback
import json, os, sys
FILEPATH_SHOWN = False

def config_get_config_file_path():

	datafilename=".fmidb.json"
	datasAt=""
	if sys.platform == "win32":
		HOME = "c:\\"
		datasAt=HOME
		datasAt = os.path.join(datasAt, "kauppalehti-notifier")
		datasAt = os.path.join(datasAt, datafilename)
	else:
		HOME = os.getenv('HOME', None)
		datasAt=HOME
		datasAt = os.path.join(datasAt, datafilename)

#	global FILEPATH_SHOWN
#	if not FILEPATH_SHOWN:
#		print("login datas at: {}".format(datasAt))
#		FILEPATH_SHOWN=True

	return datasAt

def config_get_data(mainUse):

	filenameFrom = config_get_config_file_path();

	data = {}
	try:
		with open(filenameFrom) as json_file:
			data = json.load(json_file)
			data = data.get(mainUse)

	except:
		print("Login data: file {} reading error".format(filenameFrom))
		traceback.print_exc(file=sys.stdout)


#	print("Login data: {} ".format(data))
	return data



