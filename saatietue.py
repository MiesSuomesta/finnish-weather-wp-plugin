
class Saatietue:

	def __init__(self, 	pairtempvalue, pairtempunits,
				pwindspeedvalue, pwindspeedunits,
				pwinddirectionvalue, pwinddirectionunits,
				pgustspeedvalue,  pgustspeedunits,
				prelhumvalue, prelhumunits,
				pdewpointvalue, pdewpointunits,
				pprecipitationamountvalue, pprecipitationamountunits,
				pprecipitationintensityvalue, pprecipitationintensityunits,
				psnowdepthvalue, psnowdepthunits,
				ppressurevalue, ppressureunits,
				phorizvisibvalue, phorizvisibunits,
				pcloudamountvalue, pcloudamountunits,
				recnro,
				rects):

		# Set it all, witch is nice.
		self.set_rec_nro (recnro)
		self.set_rec_ts (rects)
		self.set_airtempvalue (pairtempvalue)
		self.set_airtempunits (pairtempunits)
		self.set_windspeedvalue (pwindspeedvalue)
		self.set_windspeedunits (pwindspeedunits)
		self.set_winddirectionvalue (pwinddirectionvalue)
		self.set_winddirectionunits (pwinddirectionunits)
		self.set_gustspeedvalue (pgustspeedvalue)
		self.set_gustspeedunits (pgustspeedunits)
		self.set_relhumvalue (prelhumvalue)
		self.set_relhumunits (prelhumunits)
		self.set_dewpointvalue (pdewpointvalue)
		self.set_dewpointunits (pdewpointunits)
		self.set_precipitationamountvalue (pprecipitationamountvalue)
		self.set_precipitationamountunits (pprecipitationamountunits)
		self.set_precipitationintensityvalue (pprecipitationintensityvalue)
		self.set_precipitationintensityunits (pprecipitationintensityunits)
		self.set_snowdepthvalue (psnowdepthvalue)
		self.set_snowdepthunits (psnowdepthunits)
		self.set_pressurevalue (ppressurevalue)
		self.set_pressureunits (ppressureunits)
		self.set_horizvisibvalue (phorizvisibvalue)
		self.set_horizvisibunits (phorizvisibunits)
		self.set_cloudamountvalue (pcloudamountvalue)
		self.set_cloudamountunits (pcloudamountunits)
		self.set_rec_nro (recnro)
		self.set_rec_ts (rects)


	def set_rec_nro (self, val):
		self.rec_nro = val

	def get_rec_nro (self):
		return self.rec_nro

	def set_rec_ts (self, val):
		self.rec_ts = val
	def get_rec_ts (self):
		return self.rec_ts

	def set_airtempvalue (self, val):
		self.airtempvalue = val
	def get_airtempvalue (self):
		return self.airtempvalue

	def set_airtempunits (self, val):
		self.airtempunits = val
	def get_airtempunits (self):
		return self.airtempunits

	def set_windspeedvalue (self, val):
		self.windspeedvalue = val
	def get_windspeedvalue (self):
		return self.windspeedvalue

	def set_windspeedunits (self, val):
		self.windspeedunits = val
	def get_windspeedunits (self):
		return self.windspeedunits

	def set_winddirectionvalue (self, val):
		self.winddirectionvalue = val
	def get_winddirectionvalue (self):
		return self.winddirectionvalue

	def set_winddirectionunits (self, val):
		self.winddirectionunits = val
	def get_winddirectionunits (self):
		return self.winddirectionunits

	def set_gustspeedvalue (self, val):
		self.gustspeedvalue = val
	def get_gustspeedvalue (self):
		return self.gustspeedvalue

	def set_gustspeedunits (self, val):
		self.gustspeedunits = val
	def get_gustspeedunits (self):
		return self.gustspeedunits

	def set_relhumvalue (self, val):
		self.relhumvalue = val
	def get_relhumvalue (self):
		return self.relhumvalue

	def set_relhumunits (self, val):
		self.relhumunits = val
	def get_relhumunits (self):
		return self.relhumunits

	def set_dewpointvalue (self, val):
		self.dewpointvalue = val
	def get_dewpointvalue (self):
		return self.dewpointvalue

	def set_dewpointunits (self, val):
		self.dewpointunits = val
	def get_dewpointunits (self):
		return self.dewpointunits

	def set_precipitationamountvalue (self, val):
		self.precipitationamountvalue = val
	def get_precipitationamountvalue (self):
		return self.precipitationamountvalue

	def set_precipitationamountunits (self, val):
		self.precipitationamountunits = val
	def get_precipitationamountunits (self):
		return self.precipitationamountunits

	def set_precipitationintensityvalue (self, val):
		self.precipitationintensityvalue = val
	def get_precipitationintensityvalue (self):
		return self.precipitationintensityvalue

	def set_precipitationintensityunits (self, val):
		self.precipitationintensityunits = val
	def get_precipitationintensityunits (self):
		return self.precipitationintensityunits

	def set_snowdepthvalue (self, val):
		self.snowdepthvalue = val
	def get_snowdepthvalue (self):
		return self.snowdepthvalue

	def set_snowdepthunits (self, val):
		self.snowdepthunits = val
	def get_snowdepthunits (self):
		return self.snowdepthunits

	def set_pressurevalue (self, val):
		self.pressurevalue = val
	def get_pressurevalue (self):
		return self.pressurevalue

	def set_pressureunits (self, val):
		self.pressureunits = val
	def get_pressureunits (self):
		return self.pressureunits

	def set_horizvisibvalue (self, val):
		self.horizvisibvalue = val
	def get_horizvisibvalue (self):
		return self.horizvisibvalue

	def set_horizvisibunits (self, val):
		self.horizvisibunits = val
	def get_horizvisibunits (self):
		return self.horizvisibunits

	def set_cloudamountvalue (self, val):
		self.cloudamountvalue = val
	def get_cloudamountvalue (self):
		return self.cloudamountvalue

	def set_cloudamountunits (self, val):
		self.cloudamountunits = val
	def get_cloudamountunits (self):
		return self.cloudamountunits


	def get_str_rec_nro (self):
		return str(self.rec_nro)

	def get_str_rec_ts (self):
		return str(self.rec_ts)

	def get_str_airtempvalue (self):
		return str(self.airtempvalue)

	def get_str_airtempunits (self):
		return str(self.airtempunits)

	def get_str_windspeedvalue (self):
		return str(self.windspeedvalue)

	def get_str_windspeedunits (self):
		return str(self.windspeedunits)

	def get_str_winddirectionvalue (self):
		return str(self.winddirectionvalue)

	def get_str_winddirectionunits (self):
		return str(self.winddirectionunits)

	def get_str_gustspeedvalue (self):
		return str(self.gustspeedvalue)

	def get_str_gustspeedunits (self):
		return str(self.gustspeedunits)

	def get_str_relhumvalue (self):
		return str(self.relhumvalue)

	def get_str_relhumunits (self):
		return str(self.relhumunits)

	def get_str_dewpointvalue (self):
		return str(self.dewpointvalue)

	def get_str_dewpointunits (self):
		return str(self.dewpointunits)

	def get_str_precipitationamountvalue (self):
		return str(self.precipitationamountvalue)

	def get_str_precipitationamountunits (self):
		return str(self.precipitationamountunits)

	def get_str_precipitationintensityvalue (self):
		return str(self.precipitationintensityvalue)

	def get_str_precipitationintensityunits (self):
		return str(self.precipitationintensityunits)

	def get_str_snowdepthvalue (self):
		return str(self.snowdepthvalue)

	def get_str_snowdepthunits (self):
		return str(self.snowdepthunits)

	def get_str_pressurevalue (self):
		return str(self.pressurevalue)

	def get_str_pressureunits (self):
		return str(self.pressureunits)

	def get_str_horizvisibvalue (self):
		return str(self.horizvisibvalue)

	def get_str_horizvisibunits (self):
		return str(self.horizvisibunits)

	def get_str_cloudamountvalue (self):
		return str(self.cloudamountvalue)

	def get_str_cloudamountunits (self):
		return str(self.cloudamountunits)


