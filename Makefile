
# Create the list of files
css = https://raw.github.com/eternicode/bootstrap-datepicker/99b6f8d3608c948a0c05c8e2e5ec3c4e2c1f96b2/css/datepicker.css\
      https://raw.github.com/harvesthq/chosen/3640fa177816aee932aaeb402a28c063c11f52da/chosen/chosen.css\
      https://raw.github.com/harvesthq/chosen/3640fa177816aee932aaeb402a28c063c11f52da/chosen/chosen-sprite.png

js = https://raw.github.com/eternicode/bootstrap-datepicker/99b6f8d3608c948a0c05c8e2e5ec3c4e2c1f96b2/js/bootstrap-datepicker.js\
	 https://raw.github.com/harvesthq/chosen/3640fa177816aee932aaeb402a28c063c11f52da/chosen/chosen.jquery.min.js

all: deleteall makecss makejs

deleteall: makedeletecss makedeletejs

makecss: 
	homedir=`pwd`; mkdir app/assets/css/vendor; cd app/assets/css/vendor; wget ${css}; cd ${homedir};

makejs: 
	homedir=`pwd`; mkdir app/assets/js/vendor; cd app/assets/js/vendor; wget ${js}; cd ${homedir};

makedeletecss:
	rm -rf app/assets/css/vendor;

makedeletejs:
	rm -rf app/assets/js/vendor;
