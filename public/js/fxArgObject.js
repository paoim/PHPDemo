/**
 * @Author: Pao Im
 * @Date: Nov 27, 2015
 */
(function(){
	var data = {
			'id' : 123,
			'name' : 'Toyata Camarry 2009',
			'price' : 14500
	},
	fxArgObject = function(field) {
		return data[field];
	};
	
	var price = fxArgObject('price');
	document.getElementById('demo').innerHTML = price;
})();

