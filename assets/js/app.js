$(document).ready(function() {
	function number_format(number, decimals, decPoint, thousandsSep){
		decimals = decimals || 0;
		number = parseFloat(number);

		if(!decPoint || !thousandsSep){
			decPoint = '.';
			thousandsSep = ',';
		}

		var roundedNumber = Math.round( Math.abs( number ) * ('1e' + decimals) ) + '';
		var numbersString = decimals ? roundedNumber.slice(0, decimals * -1) : roundedNumber;
		var decimalsString = decimals ? roundedNumber.slice(decimals * -1) : '';
		var formattedNumber = "";

		while(numbersString.length > 3){
			formattedNumber += thousandsSep + numbersString.slice(-3)
			numbersString = numbersString.slice(0,-3);
		}

		return (number < 0 ? '-' : '') + numbersString + formattedNumber + (decimalsString ? (decPoint + decimalsString) : '');
	}

	jQuery.fn.dataTable.Api.register( 'sum()', function ( ) {
	    return this.flatten().reduce( function ( a, b ) {
	        if ( typeof a === 'string' ) {
	            a = a.replace(/[^\d.-]/g, '') * 1;
	        }
	        if ( typeof b === 'string' ) {
	            b = b.replace(/[^\d.-]/g, '') * 1;
	        }
	 
	        return a + b;
	    }, 0 );
	} );

	//english format
	number_format( 1234.50, 2, '.', ',' ); // ~> "1,234.50"

	//german format
	number_format( 1234.50, 2, ',', '.' ); // ~> "1.234,50"

	//french format
	number_format( 1234.50, 2, '.', ' ' ); // ~> "1 234.50"

	$(".go-back").on('click', function() {
		window.history.back();
	});


	$(".btn-send-feedback").on('click', function() {
        var data = $(".submit-feedback").serialize(),
		    base = $(".navbar").data('url'),
            url = base + "Main/sendEmail";
        $.ajax({
            dataType: "json",
            url: url,
            data: data,
            type: "POST",
            success: function(result) {
                
            }
        });
	});


});