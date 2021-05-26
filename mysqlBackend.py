
import mysql.connector as MYCN
from loginmanager import *

# db initti:
# create table saatieto ( stationid BIGINT, stationname VARCHAR(250), latitude FLOAT, longitude FLOAT, airtempvalue FLOAT, airtempunits FLOAT,  windspeedvalue FLOAT, windspeedunits FLOAT,  winddirectionvalue FLOAT, winddirectionunits FLOAT,  gustspeedvalue FLOAT, gustspeedunits FLOAT,  relhumvalue FLOAT, relhumunits FLOAT,  dewpointvalue FLOAT, dewpointunits FLOAT,  precipitationamountvalue FLOAT, precipitationamountunits FLOAT,  precipitationintensityvalue FLOAT, precipitationintensityunits FLOAT,  snowdepthvalue FLOAT, snowdepthunits FLOAT,  pressurevalue FLOAT, pressureunits FLOAT,  horizvisibvalue FLOAT, horizvisibunits FLOAT,  cloudamountvalue FLOAT, cloudamountunits FLOAT, record_nro BIGINT, record_ts TIMESTAMP DEFAULT CURRENT_TIMESTAMP );

class MySQLBackend:

	def __init__(self):

		self.login = config_get_data("fmidb")

		self.mysql_conn = None

	def mysql_connect(self):
		""" Connect to MySQL database """
		self.mysql_conn = None

		try:
			self.mysql_conn = MYCN.connect(host=self.login['hostname'],
						database=self.login['databasename'],
						user=self.login['username'],
						password=self.login['password'])

		except Error as e:
			if self.mysql_conn is not None and self.mysql_conn.is_connected():
				self.mysql_conn.close()
			print(e)

		return self.mysql_conn


	def palauta_mittaus_numeron_tiedot(self, recordNro = None):

		record = recordNro

		try:

			cursor = self.pre_mysql()

			query = 'select * from {} where record_nro = {}'.format(self.login['weatherinfotable'], record)
			
			cursor.execute(query, ())
			record = cursor.fetchall()

			print("query", query )
			print("recordit", record )

			self.post_mysql(cursor)

		except Error as error:
			if self.mysql_conn is not None and self.mysql_conn.is_connected():
				self.mysql_conn.close()

			traceback.print_exc(file=sys.stdout)
			print(error)
			cursor = None

		return record

	def palauta_viimeisin_tietueen_numero(self):

		record = None

		cursor = self.pre_mysql()

		query = 'SELECT MAX(record_nro) FROM {};'.format(self.login['weatherinfotable'])
		cursor.execute(query, ())
		record = cursor.fetchall()

		recnro = 0
		for row in record:
			recnro = row[12]

		self.post_mysql(cursor)

		return recnro



	def pre_mysql(self):

		cursor = None

		try:
			if self.mysql_conn is None:
				self.mysql_conn = self.mysql_connect()

			cursor = self.mysql_conn.cursor()

		except Error as error:
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

		query = 'select * from {}'.format(self.login['weatherinfotable'])
		cursor.execute(query, ())
		record = cursor.fetchall()

		self.post_mysql(cursor)

		return record


	def lisaa_osake_kantaan(self, osakeObjecti):
## stationid BIGINT, stationname VARCHAR(250), latitude FLOAT, longitude FLOAT, airtempvalue FLOAT, airtempunits FLOAT,  windspeedvalue FLOAT, windspeedunits FLOAT,  winddirectionvalue FLOAT, winddirectionunits FLOAT,  gustspeedvalue FLOAT, gustspeedunits FLOAT,  relhumvalue FLOAT, relhumunits FLOAT,  dewpointvalue FLOAT, dewpointunits FLOAT,  precipitationamountvalue FLOAT, precipitationamountunits FLOAT,  precipitationintensityvalue FLOAT, precipitationintensityunits FLOAT,  snowdepthvalue FLOAT, snowdepthunits FLOAT,  pressurevalue FLOAT, pressureunits FLOAT,  horizvisibvalue FLOAT, horizvisibunits FLOAT,  cloudamountvalue FLOAT, cloudamountunits FLOAT, record_nro BIGINT, record_ts TIMESTAMP DEFAULT CURRENT_TIMESTAMP
## ID BIGINT PRIMARY KEY AUTO_INCREMENT, Osake TINYTEXT, Paivays DATE, Hinta FLOAT, Muutos FLOAT, Osto FLOAT, Myynti FLOAT, Vaihto BIGINT , Ylin FLOAT, Alin FLOAT, Suositus TEXT

## stationid, stationname, latitude, longitude, airtempvalue, airtempunits,  windspeedvalue, windspeedunits,  winddirectionvalue, winddirectionunits,  gustspeedvalue, gustspeedunits,  relhumvalue, relhumunits,  dewpointvalue, dewpointunits, 
## precipitationamountvalue, precipitationamountunits,  precipitationintensityvalue, precipitationintensityunits,  snowdepthvalue, snowdepthunits,  pressurevalue, pressureunits,  horizvisibvalue, horizvisibunits,  cloudamountvalue, cloudamountunits,
## record_nro, record_ts

## 



		try:
			if self.mysql_conn is None:
				self.mysql_conn = self.mysql_connect()

			cursor = self.mysql_conn.cursor()


			query = 'INSERT INTO saatieto(Id, Osake, Paivays, Hinta, Muutos, Osto, Myynti, Vaihto, Ylin, Alin, Suositus) VALUES(%d, %s, %f, %f, %f, %f,  %f, %s,  %f, %s,  %f, %s,  %f, %s,  %f, %s, %f, %s,  %f, %s,  %f, %s,  %f, %s,  %f, %s,  %f, %s, %d, %s)'


			args = (	cursor.lastrowid,		# %s
					osakeObjecti.Osake,		# %s
					osakeObjecti.Paivays,		# %s
					osakeObjecti.Hinta,		# %s
					osakeObjecti.Muutos,		# %s
					osakeObjecti.Osto,		# %s
					osakeObjecti.Myynti,		# %s
					osakeObjecti.Vaihto,		# %s
					osakeObjecti.Ylin,		# %s
					osakeObjecti.Alin,		# %s
					osakeObjecti.Suositus )		# %s


			cursor.execute(query, args)

			self.mysql_conn.commit()

		except Error as error:
			if self.mysql_conn is not None and self.mysql_conn.is_connected():
				self.mysql_conn.close()

			traceback.print_exc(file=sys.stdout)
			print(error)

		finally:
			cursor.close()
			self.mysql_conn.close()
			self.mysql_conn = None;

