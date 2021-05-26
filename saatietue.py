
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


	set_rec_nro (self, val)
		self.rec_nro = val
	get_rec_nro (self):
		return self.rec_nro

	set_rec_ts (self, val)
		self.rec_ts = val
	get_rec_ts (self):
		return self.rec_ts

	set_airtempvalue (self, val)
		self.airtempvalue = val
	get_airtempvalue (self):
		return self.airtempvalue

	set_airtempunits (self, val)
		self.airtempunits = val
	get_airtempunits (self):
		return self.airtempunits

	set_windspeedvalue (self, val)
		self.windspeedvalue = val
	get_windspeedvalue (self):
		return self.windspeedvalue

	set_windspeedunits (self, val)
		self.windspeedunits = val
	get_windspeedunits (self):
		return self.windspeedunits

	set_winddirectionvalue (self, val)
		self.winddirectionvalue = val
	get_winddirectionvalue (self):
		return self.winddirectionvalue

	set_winddirectionunits (self, val)
		self.winddirectionunits = val
	get_winddirectionunits (self):
		return self.winddirectionunits

	set_gustspeedvalue (self, val)
		self.gustspeedvalue = val
	get_gustspeedvalue (self):
		return self.gustspeedvalue

	set_gustspeedunits (self, val)
		self.gustspeedunits = val
	get_gustspeedunits (self):
		return self.gustspeedunits

	set_relhumvalue (self, val)
		self.relhumvalue = val
	get_relhumvalue (self):
		return self.relhumvalue

	set_relhumunits (self, val)
		self.relhumunits = val
	get_relhumunits (self):
		return self.relhumunits

	set_dewpointvalue (self, val)
		self.dewpointvalue = val
	get_dewpointvalue (self):
		return self.dewpointvalue

	set_dewpointunits (self, val)
		self.dewpointunits = val
	get_dewpointunits (self):
		return self.dewpointunits

	set_precipitationamountvalue (self, val)
		self.precipitationamountvalue = val
	get_precipitationamountvalue (self):
		return self.precipitationamountvalue

	set_precipitationamountunits (self, val)
		self.precipitationamountunits = val
	get_precipitationamountunits (self):
		return self.precipitationamountunits

	set_precipitationintensityvalue (self, val)
		self.precipitationintensityvalue = val
	get_precipitationintensityvalue (self):
		return self.precipitationintensityvalue

	set_precipitationintensityunits (self, val)
		self.precipitationintensityunits = val
	get_precipitationintensityunits (self):
		return self.precipitationintensityunits

	set_snowdepthvalue (self, val)
		self.snowdepthvalue = val
	get_snowdepthvalue (self):
		return self.snowdepthvalue

	set_snowdepthunits (self, val)
		self.snowdepthunits = val
	get_snowdepthunits (self):
		return self.snowdepthunits

	set_pressurevalue (self, val)
		self.pressurevalue = val
	get_pressurevalue (self):
		return self.pressurevalue

	set_pressureunits (self, val)
		self.pressureunits = val
	get_pressureunits (self):
		return self.pressureunits

	set_horizvisibvalue (self, val)
		self.horizvisibvalue = val
	get_horizvisibvalue (self):
		return self.horizvisibvalue

	set_horizvisibunits (self, val)
		self.horizvisibunits = val
	get_horizvisibunits (self):
		return self.horizvisibunits

	set_cloudamountvalue (self, val)
		self.cloudamountvalue = val
	get_cloudamountvalue (self):
		return self.cloudamountvalue

	set_cloudamountunits (self, val)
		self.cloudamountunits = val
	get_cloudamountunits (self):
		return self.cloudamountunits


	get_str_rec_nro (self):
		return str(self.rec_nro)

	get_str_rec_ts (self):
		return str(self.rec_ts)

	get_str_airtempvalue (self):
		return str(self.airtempvalue)

	get_str_airtempunits (self):
		return str(self.airtempunits)

	get_str_windspeedvalue (self):
		return str(self.windspeedvalue)

	get_str_windspeedunits (self):
		return str(self.windspeedunits)

	get_str_winddirectionvalue (self):
		return str(self.winddirectionvalue)

	get_str_winddirectionunits (self):
		return str(self.winddirectionunits)

	get_str_gustspeedvalue (self):
		return str(self.gustspeedvalue)

	get_str_gustspeedunits (self):
		return str(self.gustspeedunits)

	get_str_relhumvalue (self):
		return str(self.relhumvalue)

	get_str_relhumunits (self):
		return str(self.relhumunits)

	get_str_dewpointvalue (self):
		return str(self.dewpointvalue)

	get_str_dewpointunits (self):
		return str(self.dewpointunits)

	get_str_precipitationamountvalue (self):
		return str(self.precipitationamountvalue)

	get_str_precipitationamountunits (self):
		return str(self.precipitationamountunits)

	get_str_precipitationintensityvalue (self):
		return str(self.precipitationintensityvalue)

	get_str_precipitationintensityunits (self):
		return str(self.precipitationintensityunits)

	get_str_snowdepthvalue (self):
		return str(self.snowdepthvalue)

	get_str_snowdepthunits (self):
		return str(self.snowdepthunits)

	get_str_pressurevalue (self):
		return str(self.pressurevalue)

	get_str_pressureunits (self):
		return str(self.pressureunits)

	get_str_horizvisibvalue (self):
		return str(self.horizvisibvalue)

	get_str_horizvisibunits (self):
		return str(self.horizvisibunits)

	get_str_cloudamountvalue (self):
		return str(self.cloudamountvalue)

	get_str_cloudamountunits (self):
		return str(self.cloudamountunits)


