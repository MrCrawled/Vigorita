'use strict';
jQuery( document ).ready( function($) {
    //muestra/oculta texto
    $(".read-more").on('click', function(){
        var key= $(this).data("key");
        $(`div[data-key="${key}"`).toggleClass("hidden");
		if($(`div[data-key="${key}"`).hasClass("hidden")){
			$(`.read-more`).html("Leer más...");
		} else {
			$(`.read-more`).html("Ver menos");
		}
    });
	
	addCaracteristicaPiso();
});

function addCaracteristicaPiso(){
	var ref = jQuery(".woocommerce-product-attributes-item.woocommerce-product-attributes-item--attribute_caracteristica-del-piso .woocommerce-product-attributes-item__value p").text();
	switch(ref){
		case "AC3":
			jQuery(".row:has(.woocommerce-product-attributes-item.woocommerce-product-attributes-item--attribute_caracteristica-del-piso .woocommerce-product-attributes-item__value p)")[0].innerHTML += `
				<div class="col-xs-12">
					<div style="display:flex;justify-content:center;">
						<img src="https://vigoritamaderassrlv.sg-host.com/wp-content/uploads/2020/01/Pisos-Flotantes-AC3-KronoSwissAC3.jpg"/>
					</div>
				</div>`;
				jQuery(".woocommerce-product-attributes-item.woocommerce-product-attributes-item--attribute_caracteristica-del-piso").remove();

			break;
		case "AC4":
			jQuery(".row:has(.woocommerce-product-attributes-item.woocommerce-product-attributes-item--attribute_caracteristica-del-piso .woocommerce-product-attributes-item__value p)")[0].innerHTML += `
				<div class="col-xs-12">
					<div style="display:flex;justify-content:center;">
						<img src="https://vigoritamaderassrlv.sg-host.com/wp-content/uploads/2020/01/Pisos-Flotantes-AC4-KronoSwissAC4.jpg"/>
					</div>
				</div>`;
							jQuery(".woocommerce-product-attributes-item.woocommerce-product-attributes-item--attribute_caracteristica-del-piso").remove();

			break;
		case "AC5":
			jQuery(".row:has(.woocommerce-product-attributes-item.woocommerce-product-attributes-item--attribute_caracteristica-del-piso .woocommerce-product-attributes-item__value p)")[0].innerHTML += `
				<div class="col-xs-12">
					<div style="display:flex;justify-content:center;">
						<img src="https://vigoritamaderassrlv.sg-host.com/wp-content/uploads/2020/01/Pisos-Flotantes-AC5-KronoSwissAC5.jpg
"/>
					</div>
				</div>`;
			jQuery(".woocommerce-product-attributes-item.woocommerce-product-attributes-item--attribute_caracteristica-del-piso").remove();
			break;
	}
}

jQuery(document).ready(function( $ ){
	$('div.product-info > b').each(function() {
  if (this.innerText.startsWith('$0,00')) { this.style = 'display: none' }  
})				
});

jQuery(document).ready(function( $ ){
	$('div.entry-summary > strong').each(function() {

  if (this.innerText.endsWith('$0,00')) { this.style = 'display: none' }  
})				
});