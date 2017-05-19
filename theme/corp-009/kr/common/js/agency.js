/** Google Map ��ü. **/
GoogleMap = {
	/* �ʱ�ȭ. */
	initialize : function(addr) {
		if(!addr)return;
		$("#GoogleMap_map").show();
		//this.input = document.getElementById("GoogleMap_input");
		this.address = addr;
		this.geocoder = new google.maps.Geocoder();
		this.infowindow = new google.maps.InfoWindow();
		this.setAgencyPosition();

	},

	setAgencyPosition : function(){
		this.geocoder.geocode( { 'address': this.address }, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				var p = results[0].geometry.location;

				//���� ����.(�⺻ ��ġ ����.)
				var latlng = new google.maps.LatLng(p.lat(),p.lng());
				var myOptions = {
					zoom: 15,
					center: latlng,
					mapTypeControl : false,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				};
				this.map = new google.maps.Map(
						document.getElementById("GoogleMap_map"),myOptions);

				//��Ŀ ����.
				this.marker = new google.maps.Marker({
					map : this.map,
					//animation: google.maps.Animation.DROP,
					position: latlng
				});

			}
		});
	},


	//�ּ� Ŭ�� �̺�Ʈ.
	clickAddress : function(a, addr,content){
		a.onmousedown = function(){
			//������ ��Ŀ�̵�.
			GoogleMap.map.setCenter(addr);
			GoogleMap.marker.setPosition(addr);
			//GoogleMap.marker.setAnimation(google.maps.Animation.DROP);
			GoogleMap.infowindow.setContent(content);
			GoogleMap.infowindow.open(GoogleMap.map,GoogleMap.marker);
		}
	}
}