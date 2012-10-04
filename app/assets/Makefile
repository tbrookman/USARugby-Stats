# To run this makefile, you must do the following.
#
# 1.)  sudo make tools -B
#

# Create the list of files
css = https://raw.github.com/eternicode/bootstrap-datepicker/99b6f8d3608c948a0c05c8e2e5ec3c4e2c1f96b2/css/datepicker.css\
      https://raw.github.com/harvesthq/chosen/3640fa177816aee932aaeb402a28c063c11f52da/chosen/chosen.css

js = https://raw.github.com/eternicode/bootstrap-datepicker/99b6f8d3608c948a0c05c8e2e5ec3c4e2c1f96b2/js/bootstrap-datepicker.js\
	 https://raw.github.com/harvesthq/chosen/3640fa177816aee932aaeb402a28c063c11f52da/chosen/chosen.jquery.min.js

installed_css = datepicker.css\
				chosen.css

installed_js = bootstrap-datepicker.js\
			   chosen.jquery.min.js

all: makecss makejs

deleteall: makedeletecss makedeletejs

makecss: 
	cd css; echo `pwd`; wget ${css}; cd ..;

makejs: 
	cd js; echo `pwd`; wget ${js}; cd ..;

makedeletecss:
	cd css; rm -rf ${installed_css}; cd ..;

makedeletejs:
	cd js; rm -rf ${installed_js}; cd ..;