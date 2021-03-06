
from pprint import pprint as pp
import mysql.connector as MYCN
from loginmanager import *
import time

class MySQLBackend:

	def __init__(self):

		self.login = config_get_data("mysql")

		#print("login info", self.login )


		self.mysql_conn = None

	def mysql_connect(self):
		""" Connect to MySQL database """
		self.mysql_conn = None
		time.sleep(0.01)
		try:
			self.mysql_conn = MYCN.connect( host=self.login['hostname'],
                                            database=self.login['databasename'],
                                            user=self.login['username'],
                                            password=self.login['password'])

		except Exception as e:
			if self.mysql_conn is not None and self.mysql_conn.is_connected():
				self.mysql_conn.close()
			print(e)

		return self.mysql_conn


	def palauta_mittaus_numeron_tiedot(self, recordNro = None):

		record = recordNro

		try:

			cursor = self.pre_mysql()

			query = 'select * from {} where recordnro = {}'.format(self.login['databasetable'], record)
			
			cursor.execute(query, ())
			record = cursor.fetchall()

		#	print("query", query )
		#	print("recordit", record )

			self.post_mysql(cursor)

		except Exception as error:
			if self.mysql_conn is not None and self.mysql_conn.is_connected():
				self.mysql_conn.close()

			traceback.print_exc(file=sys.stdout)
			print(error)
			cursor = None

		return record

	def palauta_viimeisin_tietueen_numero(self):

		record = None

		cursor = self.pre_mysql()

		query = 'SELECT max(recordnro) FROM {};'.format(self.login['databasetable'])
		cursor.execute(query, ())
		record = cursor.fetchall()

		recnro = 0

	#	print("Record: ")
	#	pp(record)

		if record:
			if record[0]:
				recnro = record[0][0]

		self.post_mysql(cursor)

		if recnro == None:
			recnro = 0;

		return recnro



	def pre_mysql(self):

		cursor = None

		try:
			if self.mysql_conn is None:
				self.mysql_conn = self.mysql_connect()

			cursor = self.mysql_conn.cursor()

		except Exception as error:
			if self.mysql_conn is not None and self.mysql_conn.is_connected():
				self.mysql_conn.close()

			traceback.print_exc(file=sys.stdout)
			print(error)
			cursor = None

		return cursor

	def post_mysql(self, cursor):


		cursor.close()
		self.mysql_conn.close()
		self.mysql_conn = None;


	def palauta_kaikki_kannasta(self):

		record = None

		cursor = self.pre_mysql(cursor)

		query = 'select * from {}'.format(self.login['databasetable'])
		cursor.execute(query, ())
		record = cursor.fetchall()

		self.post_mysql(cursor)
		return record


	def lisaa_osake_kantaan(self, saatietue):
## stationid BIGINT, stationname VARCHAR(250), latitude FLOAT, longitude FLOAT, airtempvalue FLOAT, airtempunits VARCHAR(150),  windspeedvalue FLOAT, windspeedunits VARCHAR(150),  winddirectionvalue FLOAT, winddirectionunits VARCHAR(150),  gustspeedvalue FLOAT, gustspeedunits VARCHAR(150),  relhumvalue FLOAT, relhumunits VARCHAR(150),  dewpointvalue FLOAT, dewpointunits VARCHAR(150),  precipitationamountvalue FLOAT, precipitationamountunits VARCHAR(150),  precipitationintensityvalue FLOAT, precipitationintensityunits VARCHAR(150),  snowdepthvalue FLOAT, snowdepthunits VARCHAR(150),  pressurevalue FLOAT, pressureunits VARCHAR(150),  horizvisibvalue FLOAT, horizvisibunits VARCHAR(150),  cloudamountvalue FLOAT, cloudamountunits VARCHAR(150), recordnro BIGINT, recordts TIMESTAMP DEFAULT CURRENT_TIMESTAMP

		try:
			if self.mysql_conn is None:
				self.mysql_conn = self.mysql_connect()

			cursor = self.mysql_conn.cursor()

			# stationid,stationname,latitude,longitude,airtempvalue,airtempunits,windspeedvalue,windspeedunits,winddirectionvalue,
			# winddirectionunits,gustspeedvalue,gustspeedunits,relhumvalue,relhumunits,dewpointvalue,dewpointunits,precipitationamountvalue,
			# precipitationamountunits,precipitationintensityvalue,precipitationintensityunits,snowdepthvalue,snowdepthunits,pressurevalue,
			# pressureunits,horizvisibvalue,horizvisibunits,cloudamountvalue,cloudamountunits,record_nro,record_ts

			mysqlargs = (	
					( 1, saatietue.get_str_stationid (), "stationid"),					# 1
					( 1, saatietue.get_str_stationname (), "stationname"),					# 
					( 1, saatietue.get_str_latitude (), "latitude"),						# 
					( 1, saatietue.get_str_longitude (), "longitude"),					# 
					( 1, saatietue.get_str_airtempvalue (), "airtempvalue"),					# 5
					( 1, saatietue.get_str_airtempunits (), "airtempunits"),					# 
					( 1, saatietue.get_str_windspeedvalue (), "windspeedvalue"),				# 
					( 1, saatietue.get_str_windspeedunits (), "windspeedunits"),				# 
					( 1, saatietue.get_str_winddirectionvalue (), "winddirectionvalue"),			# 
					( 1, saatietue.get_str_winddirectionunits (), "winddirectionunits"),			# 10
					( 1, saatietue.get_str_gustspeedvalue (), "gustspeedvalue"),				# 
					( 1, saatietue.get_str_gustspeedunits (), "gustspeedunits"),				# 
					( 1, saatietue.get_str_relhumvalue (), "relhumvalue"),					# 
					( 1, saatietue.get_str_relhumunits (), "relhumunits"),					# 
					( 1, saatietue.get_str_dewpointvalue (), "dewpointvalue"),				# 15
					( 1, saatietue.get_str_dewpointunits (), "dewpointunits"),				# 
					( 1, saatietue.get_str_precipitationamountvalue (), "precipitationamountvalue"),		# 
					( 1, saatietue.get_str_precipitationamountunits (), "precipitationamountunits"),		# 
					( 1, saatietue.get_str_precipitationintensityvalue (), "precipitationintensityvalue"),	# 
					( 1, saatietue.get_str_precipitationintensityunits (), "precipitationintensityunits"),	# 20
					( 1, saatietue.get_str_snowdepthvalue (), "snowdepthvalue"),				# 
					( 1, saatietue.get_str_snowdepthunits (), "snowdepthunits"),				# 
					( 1, saatietue.get_str_pressurevalue (), "pressurevalue"),				# 
					( 1, saatietue.get_str_pressureunits (), "pressureunits"),				# 
					( 1, saatietue.get_str_horizvisibvalue (), "horizvisibvalue"),				# 25
					( 1, saatietue.get_str_horizvisibunits (), "horizvisibunits"),				# 
					( 1, saatietue.get_str_cloudamountvalue (), "cloudamountvalue"),				# 
					( 1, saatietue.get_str_cloudamountunits (), "cloudamountunits"),				# 
					( 1, saatietue.get_str_rec_nro (), "recordnro"),						# 
					( 0, saatietue.get_str_rec_ts (), "recordts"),						# 30
				)

			fields = "";
			formats = "";
			values = "";
			count = 0;
			for msa in mysqlargs:
				#print("{} msa: ".format(count))
				#pp(msa)

				m  = msa[0]
				va = msa[1]
				fi = msa[2]

				delim = ", "
				if m == 0:
					delim = ""

				val = '"{}"'.format(va)

				fields  = fields  + fi + delim
				values  = values  + val + delim
				count+=1
                
			#print("Count: {}\n".format(count))
			#print("Fields : {}\n".format(fields))
			#print("Values : {}\n".format(values))

			query_start = 'INSERT INTO {} '.format(self.login['databasetable'])
			query = query_start + "(" + fields + ') VALUES('+ values +');'

			#print("Query  : " + query + "\n");

			cursor.execute(query, ())

			self.mysql_conn.commit()

		except Exception as error:
			if self.mysql_conn is not None and self.mysql_conn.is_connected():
				self.mysql_conn.close()

			traceback.print_exc(file=sys.stdout)
			print(error)

		finally:
			cursor.close()
			self.mysql_conn.close()
			self.mysql_conn = None;

