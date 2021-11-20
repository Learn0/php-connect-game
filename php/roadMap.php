<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>지도에 사용자 컨트롤 올리기</title>
        <style>
            html, body {
            	width: 100%;
            	height: 100%;
            	margin: 0;
            	padding: 0;
            }
            .radius_border {
            	border: 1px solid #919191;
            	border-radius: 5px;
            }
            .custom_typecontrol {
            	position: absolute;
            	top: 10px;
            	right: 10px;
            	overflow: hidden;
            	width: 130px;
            	height: 30px;
            	margin: 0;
            	padding: 0;
            	z-index: 1;
            	font-size: 12px;
            	font-family: 'Malgun Gothic', '맑은 고딕', sans-serif;
            }
            .custom_search {
            	position: absolute;
            	top: 10px;
            	left: 60px;
            	overflow: hidden;
            	width: 65px;
            	height: 30px;
            	margin: 0;
            	padding: 0;
            	z-index: 1;
            	font-size: 12px;
            	font-family: 'Malgun Gothic', '맑은 고딕', sans-serif;
            }
            .custom_search span, .custom_typecontrol span {
            	display: block;
            	width: 65px;
            	height: 30px;
            	float: left;
            	text-align: center;
            	line-height: 30px;
            	cursor: pointer;
            }
            .custom_search .btn, .custom_typecontrol .btn {
            	background: #fff;
            	background: linear-gradient(#fff, #e6e6e6);
            }
            .custom_search .btn:hover, .custom_typecontrol .btn:hover {
            	background: #f5f5f5;
            	background: linear-gradient(#f5f5f5, #e3e3e3);
            }
            .custom_search .btn:active, .custom_typecontrol .btn:active {
            	background: #e6e6e6;
            	background: linear-gradient(#e6e6e6, #fff);
            }
            .custom_search .selected_btn, .custom_typecontrol .selected_btn {
            	color: #fff;
            	background: #425470;
            	background: linear-gradient(#425470, #5b6d8a);
            }
            .custom_search .selected_btn:hover, .custom_typecontrol .selected_btn:hover
            	{
            	color: #fff;
            }
            .custom_zoomcontrol {
            	position: absolute;
            	top: 50px;
            	right: 10px;
            	width: 36px;
            	height: 80px;
            	overflow: hidden;
            	z-index: 1;
            	background-color: #f5f5f5;
            }
            .custom_zoomcontrol span {
            	display: block;
            	width: 36px;
            	height: 40px;
            	text-align: center;
            	cursor: pointer;
            }
            .custom_zoomcontrol span img {
            	width: 15px;
            	height: 15px;
            	padding: 12px 0;
            	border: none;
            }
            .custom_zoomcontrol span:first-child {
            	border-bottom: 1px solid #bfbfbf;
            }
            
            #container {
            	overflow: hidden;
            	height: 100%;
            	position: relative;
            }
            
            #mapWrapper {
            	width: 100%;
            	height: 100%;
            	z-index: 1;
            }
            
            #rvWrapper {
            	width: 50%;
            	height: 100%;
            	top: 0;
            	right: 0;
            	position: absolute;
            	z-index: 0;
            }
            
            #container.view_roadview #mapWrapper {
            	width: 50%;
            }
            
            #roadviewControl {
            	position: absolute;
            	top: 5px;
            	left: 5px;
            	width: 42px;
            	height: 42px;
            	z-index: 1;
            	cursor: pointer;
            	background:
            		url(https://t1.daumcdn.net/localimg/localimages/07/2018/pc/common/img_search.png)
            		0 -450px no-repeat;
            }
            
            #roadviewControl.active {
            	background-position: 0 -350px;
            }
            
            #close {
            	position: absolute;
            	padding: 4px;
            	top: 5px;
            	left: 5px;
            	cursor: pointer;
            	background: #fff;
            	border-radius: 4px;
            	border: 1px solid #c8c8c8;
            	box-shadow: 0px 1px #888;
            }
            
            #close .img {
            	display: block;
            	background:
            		url(https://t1.daumcdn.net/localimg/localimages/07/mapapidoc/rv_close.png)
            		no-repeat;
            	width: 14px;
            	height: 14px;
            }
            
            #menu_wrap {
            	position: absolute;
            	top: 0;
            	left: 0;
            	bottom: 0;
            	width: 300px;
            	margin: 50px 0 30px 7px;
            	padding: 5px;
            	overflow-y: auto;
            	background: rgba(255, 255, 255, 0.7);
            	z-index: 1;
            	font-size: 12px;
            	border-radius: 10px;
            	display: none;
            }
            
            .bg_white {
            	background: #fff;
            }
            
            #menu_wrap hr {
            	display: block;
            	height: 1px;
            	border: 0;
            	border-top: 2px solid #5F5F5F;
            	margin: 3px 0;
            }
            
            #menu_wrap .option {
            	text-align: left;
            	margin: 0 5px;
            }
            
            #menu_wrap .option button {
            	margin-left: 5px;
            }
            
            #placesList {
            	margin-left: -20px;
            }
            
            #placesList .item {
            	position: relative;
            	border-bottom: 1px solid #888;
            	overflow: hidden;
            	cursor: pointer;
            	min-height: 65px;
            }
            
            #placesList .item span {
            	display: block;
            	margin-top: 4px;
            }
            
            #placesList .item .info {
            	/*text-overflow: ellipsis;
            	overflow: hidden;
            	white-space: nowrap;*/
            	word-break: keep-all;
            }
            
            #placesList .item .info {
            	padding: 0 0 10px 40px;
            }
            
            #placesList .info .gray {
            	color: #8a8a8a;
            }
            
            #placesList .info .jibun {
            	padding-left: 26px;
            	background:
            		url(https://t1.daumcdn.net/localimg/localimages/07/mapapidoc/places_jibun.png)
            		no-repeat;
            }
            
            #placesList .info .tel {
            	color: #009900;
            }
            
            #placesList .item .markerbg {
            	float: left;
            	position: absolute;
            	width: 36px;
            	height: 37px;
            	background:
            		url(https://t1.daumcdn.net/localimg/localimages/07/mapapidoc/marker_number_blue.png)
            		no-repeat;
            }
            
            #placesList .item .marker_1 {
            	background-position: 0 -10px;
            }
            
            #placesList .item .marker_2 {
            	background-position: 0 -56px;
            }
            
            #placesList .item .marker_3 {
            	background-position: 0 -102px
            }
            
            #placesList .item .marker_4 {
            	background-position: 0 -148px;
            }
            
            #placesList .item .marker_5 {
            	background-position: 0 -194px;
            }
            
            #placesList .item .marker_6 {
            	background-position: 0 -240px;
            }
            
            #placesList .item .marker_7 {
            	background-position: 0 -286px;
            }
            
            #placesList .item .marker_8 {
            	background-position: 0 -332px;
            }
            
            #placesList .item .marker_9 {
            	background-position: 0 -378px;
            }
            
            #placesList .item .marker_10 {
            	background-position: 0 -423px;
            }
            
            #placesList .item .marker_11 {
            	background-position: 0 -470px;
            }
            
            #placesList .item .marker_12 {
            	background-position: 0 -516px;
            }
            
            #placesList .item .marker_13 {
            	background-position: 0 -562px;
            }
            
            #placesList .item .marker_14 {
            	background-position: 0 -608px;
            }
            
            #placesList .item .marker_15 {
            	background-position: 0 -654px;
            }
            
            #pagination {
            	margin: 10px auto;
            	text-align: center;
            }
            
            #pagination a {
            	display: inline-block;
            	margin-right: 10px;
            }
            
            #pagination .on {
            	font-weight: bold;
            	cursor: default;
            	color: #777;
            }
        }
        </style>
    </head>
    <body>
    	<div id="container">
    		<div id="rvWrapper">
    			<div id="roadview" style="width: 100%; height: 100%;"></div>
    			<!-- 로드뷰를 표시할 div 입니다 -->
    			<div id="close" title="로드뷰닫기" onclick="closeRoadview()">
    				<span class="img"></span>
    			</div>
    		</div>
    		<div id="mapWrapper">
    			<div id="map"
    				style="width: 100%; height: 100%; position: relative; overflow: hidden;"></div>
    			<!-- 지도타입 컨트롤 div 입니다 -->
    			<div class="custom_typecontrol radius_border">
    				<span id="btnRoadmap" class="selected_btn"
    					onclick="setMapType('roadmap')">지도</span> <span id="btnSkyview"
    					class="btn" onclick="setMapType('skyview')">스카이뷰</span>
    			</div>
    			<!-- 지도 확대, 축소 컨트롤 div 입니다 -->
    			<div class="custom_zoomcontrol radius_border">
    				<span onclick="zoomIn()"><img
    					src="https://t1.daumcdn.net/localimg/localimages/07/mapapidoc/ico_plus.png"
    					alt="확대"></span> <span onclick="zoomOut()"><img
    					src="https://t1.daumcdn.net/localimg/localimages/07/mapapidoc/ico_minus.png"
    					alt="축소"></span>
    			</div>
    			<div id="roadviewControl" onclick="setRoadviewRoad()"></div>
    			<div class="custom_search radius_border">
    				<span id="btnSearch" class="btn" onclick="openSearch()">키워드</span>
    			</div>
    			<div id="menu_wrap" class="bg_white">
    				<div class="option">
    					<div>
    						<form onsubmit="searchPlaces(); return false;">
    							키워드 : <input type="text" id="keyword" size="15" />
    							<button type="submit">검색하기</button>
    						</form>
    					</div>
    				</div>
    				<hr>
    				<ul id="placesList"></ul>
    				<div id="pagination"></div>
    			</div>
    		</div>
    	</div>
    
    	<script src="http://code.jquery.com/jquery-1.11.0.js"></script>
    	<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=cd60f0d60f8ebf56777090aefd9990eb&libraries=services"></script>
    	<script>
    		let map, mapCenter;
    
            let latitude, longitude, title;
            
    		<?php
            if(isset($_GET["latitude"])){
                echo "latitude = ".$_GET["latitude"].";";
            }
            if(isset($_GET["longitude"])){
                echo "longitude = ".$_GET["longitude"].";";
            }
            if(isset($_GET["title"])){
                echo "title = '".$_GET["title"]."';";
            }
            ?>
    
            $(function(){
                if(latitude != null && longitude != null){
                	mapCenter = new kakao.maps.LatLng(latitude, longitude), // 지도의 중심좌표
                    mapOption = {
                        center: mapCenter, // 지도의 중심좌표
                        level: 3 // 지도의 확대 레벨
                    };
                	LoadMap();
                } else {
                    // Geolocation API에 액세스할 수 있는지를 확인
                    if (navigator.geolocation) {
                        //위치 정보를 얻기
                        navigator.geolocation.getCurrentPosition (function(pos) {
                         	mapCenter = new kakao.maps.LatLng(pos.coords.latitude, pos.coords.longitude), // 지도의 중심좌표
                            mapOption = {
                                center: mapCenter, // 지도의 중심좌표
                                level: 3 // 지도의 확대 레벨
                            };
                        	LoadMap();
                        }, function(pos) {
                        	mapCenter = new kakao.maps.LatLng("37.567", "126.979"), // 지도의 중심좌표
                            mapOption = {
                                center: mapCenter, // 지도의 중심좌표
                                level: 5 // 지도의 확대 레벨
                            };
                        	LoadMap();
                        });
                    } else {
                        alert("이 브라우저에서는 Geolocation이 지원되지 않습니다.")
                    }
                }
            });
        
            let overlayOn = false; // 지도 위에 로드뷰 오버레이가 추가된 상태를 가지고 있을 변수
            let container = $("#container"); // 지도와 로드뷰를 감싸고 있는 div 입니다
        
            // 마커를 담을 배열입니다
           	let markers = [];
        
           	// 장소 검색 객체를 생성합니다
           	let ps = new kakao.maps.services.Places();  
        
           	// 검색 결과 목록이나 마커를 클릭했을 때 장소명을 표출할 인포윈도우를 생성합니다
           	let infowindow = new kakao.maps.InfoWindow({
           	    disableAutoPan: true,
           	    zIndex:1
           	});
        
            let rv,
        	rvClient,
        	marker;
            function LoadMap(){
            	let mapContainer = $("#map")[0]; // 지도를 표시할 div 입니다 
                map = new kakao.maps.Map(mapContainer, mapOption);


                if(latitude != null && longitude != null){
    		        // 결과값으로 받은 위치를 마커로 표시합니다
    		        let marker = new kakao.maps.Marker({
    		            map: map,
    		            position: mapCenter
    		        });
    
    		        // 인포윈도우로 장소에 대한 설명을 표시합니다
    		        let infowindow = new kakao.maps.InfoWindow({
    		            content: '<div style="width:150px; text-align:center; padding:6px 0">'+title+'</div>'
    		        });
    		        infowindow.open(map, marker);
    
    		        // 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
    		        map.setCenter(mapCenter);
                }

		        
                let rvContainer = $("#roadview"); //로드뷰를 표시할 div 입니다
                // 로드뷰 객체를 생성합니다 
                rv = new kakao.maps.Roadview(rvContainer[0]); 
            
                // 좌표로부터 로드뷰 파노라마 ID를 가져올 로드뷰 클라이언트 객체를 생성합니다 
                rvClient = new kakao.maps.RoadviewClient(); 
        
                // 마커 이미지를 생성합니다
                let markImage = new kakao.maps.MarkerImage(
                    'https://t1.daumcdn.net/localimg/localimages/07/2018/pc/roadview_minimap_wk_2018.png',
                    new kakao.maps.Size(26, 46),
                    {
                        // 스프라이트 이미지를 사용합니다.
                        // 스프라이트 이미지 전체의 크기를 지정하고
                        spriteSize: new kakao.maps.Size(1666, 168),
                        // 사용하고 싶은 영역의 좌상단 좌표를 입력합니다.
                        // background-position으로 지정하는 값이며 부호는 반대입니다.
                        spriteOrigin: new kakao.maps.Point(705, 114),
                        offset: new kakao.maps.Point(13, 46)
                    }
                );
        
                // 드래그가 가능한 마커를 생성합니다
                marker = new kakao.maps.Marker({
                    image : markImage,
                    position: mapCenter,
                    draggable: true
                });
                
                // 로드뷰에 좌표가 바뀌었을 때 발생하는 이벤트를 등록합니다 
                kakao.maps.event.addListener(rv, 'position_changed', function() {
        
                    // 현재 로드뷰의 위치 좌표를 얻어옵니다 
                    let rvPosition = rv.getPosition();
        
                    // 지도의 중심을 현재 로드뷰의 위치로 설정합니다
                    map.setCenter(rvPosition);
        
                    // 지도 위에 로드뷰 도로 오버레이가 추가된 상태이면
                    if(overlayOn) {
                        // 마커의 위치를 현재 로드뷰의 위치로 설정합니다
                        marker.setPosition(rvPosition);
                    }
                });
        
               	// 마커에 dragend 이벤트를 등록합니다
               	kakao.maps.event.addListener(marker, 'dragend', function(mouseEvent) {
    
                   	// 현재 마커가 놓인 자리의 좌표입니다 
                   	let position = marker.getPosition();
    
                   	// 마커가 놓인 위치를 기준으로 로드뷰를 설정합니다
                   	toggleRoadview(position);
               	});
    
               	//지도에 클릭 이벤트를 등록합니다
           		kakao.maps.event.addListener(map, 'click', function(mouseEvent){
                   
                   	// 지도 위에 로드뷰 도로 오버레이가 추가된 상태가 아니면 클릭이벤트를 무시합니다 
                   	if(!overlayOn) {
                       	return;
                   	}
    
                   	// 클릭한 위치의 좌표입니다 
                   	let position = mouseEvent.latLng;
    
                   	// 마커를 클릭한 위치로 옮깁니다
               		marker.setPosition(position);
    
                   	// 클락한 위치를 기준으로 로드뷰를 설정합니다
                   	toggleRoadview(position);
           		});
        	}
            
            // 지도타입 컨트롤의 지도 또는 스카이뷰 버튼을 클릭하면 호출되어 지도타입을 바꾸는 함수입니다
            function setMapType(maptype) { 
                let roadmapControl = $("#btnRoadmap");
                let skyviewControl = $("#btnSkyview"); 
                if (maptype === 'roadmap') {
                	map.setMapTypeId(kakao.maps.MapTypeId.ROADMAP);  
                    roadmapControl.removeClass('btn').addClass('selected_btn');
                    skyviewControl.removeClass('selected_btn').addClass('btn');
                } else {
                    map.setMapTypeId(kakao.maps.MapTypeId.HYBRID);    
                    skyviewControl.removeClass('btn').addClass('selected_btn');
                    roadmapControl.removeClass('selected_btn').addClass('btn');
                }
            }
            
            // 지도 확대, 축소 컨트롤에서 확대 버튼을 누르면 호출되어 지도를 확대하는 함수입니다
            function zoomIn() {
                map.setLevel(map.getLevel() - 1);
            }
            
            // 지도 확대, 축소 컨트롤에서 축소 버튼을 누르면 호출되어 지도를 확대하는 함수입니다
            function zoomOut() {
                map.setLevel(map.getLevel() + 1);
            }
        
             // 전달받은 좌표(position)에 가까운 로드뷰의 파노라마 ID를 추출하여
             // 로드뷰를 설정하는 함수입니다
             function toggleRoadview(position){
                 rvClient.getNearestPanoId(position, 50, function(panoId) {
                     // 파노라마 ID가 null 이면 로드뷰를 숨깁니다
                     if (panoId == null) {
                         toggleMapWrapper(true, position);
                     } else {
                      toggleMapWrapper(false, position);
            
                         // panoId로 로드뷰를 설정합니다
                         rv.setPanoId(panoId, position);
                     }
                 });
             }
            
             // 지도를 감싸고 있는 div의 크기를 조정하는 함수입니다
             function toggleMapWrapper(active, position) {
                 if (active) {
                     // 지도를 감싸고 있는 div의 너비가 100%가 되도록 class를 변경합니다 
                    	 container.removeClass('view_roadview');
            
                     // 지도의 크기가 변경되었기 때문에 relayout 함수를 호출합니다
                     map.relayout();
            
                     // 지도의 너비가 변경될 때 지도중심을 입력받은 위치(position)로 설정합니다
                     map.setCenter(position);
                 } else {
                     // 지도만 보여지고 있는 상태이면 지도의 너비가 50%가 되도록 class를 변경하여
                     // 로드뷰가 함께 표시되게 합니다
                     if (container.attr('class') === undefined || container.attr('class') === '') {
                    	 container.addClass('view_roadview');
            
                         // 지도의 크기가 변경되었기 때문에 relayout 함수를 호출합니다
                         map.relayout();
            
                         // 지도의 너비가 변경될 때 지도중심을 입력받은 위치(position)로 설정합니다
                         map.setCenter(position);
                     }
                 }
             }
            
         	// 지도 위의 로드뷰 도로 오버레이를 추가,제거하는 함수입니다
         	function toggleOverlay(active) {
             	if (active) {
                 	overlayOn = true;
            
                     // 지도 위에 로드뷰 도로 오버레이를 추가합니다
                     map.addOverlayMapTypeId(kakao.maps.MapTypeId.ROADVIEW);
            
                     // 지도 위에 마커를 표시합니다
                     marker.setMap(map);
            
                     // 마커의 위치를 지도 중심으로 설정합니다 
                     marker.setPosition(map.getCenter());
            
                     // 로드뷰의 위치를 지도 중심으로 설정합니다
                     toggleRoadview(map.getCenter());
                 } else {
                     overlayOn = false;
            
                     // 지도 위의 로드뷰 도로 오버레이를 제거합니다
                     map.removeOverlayMapTypeId(kakao.maps.MapTypeId.ROADVIEW);
            
                     // 지도 위의 마커를 제거합니다
                     marker.setMap(null);
                 }
         	}
            
         	// 지도 위의 로드뷰 버튼을 눌렀을 때 호출되는 함수입니다
         	function setRoadviewRoad() {
             	let control = $("#roadviewControl");
            
             	// 버튼이 눌린 상태가 아니면
             	if (control.attr('class') === undefined || control.attr('class') === '') {
                 	control.addClass('active');
            
                     // 로드뷰 도로 오버레이가 보이게 합니다
                 	toggleOverlay(true);
             	} else {
                     control.removeClass('active');
            
                     // 로드뷰 도로 오버레이를 제거합니다
                     toggleOverlay(false);
            
                     let position = marker.getPosition();
                     toggleMapWrapper(true, position);
             	}
         	}
            
             // 로드뷰에서 X버튼을 눌렀을 때 로드뷰를 지도 뒤로 숨기는 함수입니다
             function closeRoadview() {
            	 setRoadviewRoad();
             }
            
             function openSearch(){
                 let searchControl = $("#btnSearch"),
                 menuControl = $("#menu_wrap");
                 
                 if (searchControl.attr("class") === "btn") {
                     searchControl.removeClass("btn").addClass("selected_btn");
                     $("#keyword").val("");
                     menuControl.scrollTop(0);
                     menuControl.show();
                     
                     // 검색 결과 목록에 추가된 항목들을 제거합니다
                     removeAllChildNods($("#placesList")[0]);
            
                     // 기존에 추가된 페이지번호를 삭제합니다
                     removeAllChildNods($("#pagination")[0]);
            
                     // 지도에 표시되고 있는 마커를 제거합니다
                     removeMarker();
                 } else {
                     searchControl.removeClass('selected_btn').addClass('btn');
                     menuControl.hide();
                 }
             }
            
            //키워드 검색을 요청하는 함수입니다
        	function searchPlaces() {
              	let keyword = $("#keyword").val();
            
              	if (!keyword.replace(/^\s+|\s+$/g, "")) {
                  	alert("키워드를 입력해주세요!");
                  	return false;
              	}
            
              	// 장소검색 객체를 통해 키워드로 장소검색을 요청합니다
              	ps.keywordSearch(keyword, placesSearchCB); 
            }
            
            //장소검색이 완료됐을 때 호출되는 콜백함수 입니다
            function placesSearchCB(data, status, pagination) {
              if (status === kakao.maps.services.Status.OK) {
            
                  // 정상적으로 검색이 완료됐으면
                  // 검색 목록과 마커를 표출합니다
                  displayPlaces(data);
            
                  // 페이지 번호를 표출합니다
                  displayPagination(pagination);
            
              } else if (status === kakao.maps.services.Status.ZERO_RESULT) {
            
                  alert('검색 결과가 존재하지 않습니다.');
                  return;
            
              } else if (status === kakao.maps.services.Status.ERROR) {
            
                  alert('검색 결과 중 오류가 발생했습니다.');
                  return;
            
              }
            }
            
            //검색 결과 목록과 마커를 표출하는 함수입니다
            function displayPlaces(places) {
          		let placesList = $("#placesList")[0];
          		fragment = document.createDocumentFragment(), 
          		bounds = new kakao.maps.LatLngBounds(),
          		listStr = '';
              
          		// 검색 결과 목록에 추가된 항목들을 제거합니다
          		removeAllChildNods(placesList);
            
          		// 지도에 표시되고 있는 마커를 제거합니다
          		removeMarker();
              
          		for ( let i=0; i<places.length; i++ ) {
                  	// 마커를 생성하고 지도에 표시합니다
                  	let placePosition = new kakao.maps.LatLng(places[i].y, places[i].x),
                  	marker = addMarker(placePosition, i), 
                  	itemEl = getListItem(i, places[i]); // 검색 결과 항목 Element를 생성합니다
            
                  	// 검색된 장소 위치를 기준으로 지도 범위를 재설정 하기 위해
                  	// LatLngBounds 객체에 좌표를 추가합니다
                  	bounds.extend(placePosition);
            
                  	// 마커와 검색결과 항목에 mouseover 했을때
                  	// 해당 장소에 인포윈도우에 장소명을 표시합니다
                  	// mouseout 했을 때는 인포윈도우를 닫습니다
              		(function(marker, title) {
                      	kakao.maps.event.addListener(marker, 'mouseover', function() {
                          	displayInfowindow(marker, title, false);
                      	});
            
                      	kakao.maps.event.addListener(marker, 'mouseout', function() {
                          	infowindow.close();
                      	});
            
                      	itemEl.onmouseover =  function () {
                          	displayInfowindow(marker, title, true);
                      	};
            
                      	itemEl.onmouseout =  function () {
                          	infowindow.close();
                      	};
                  	})(marker, places[i].place_name);
            
                  	fragment.appendChild(itemEl);
      			}
            
              	// 검색결과 항목들을 검색결과 목록 Elemnet에 추가합니다
              	placesList.appendChild(fragment);
              	$("#menu_wrap").scrollTop(0);
            
              	// 검색된 장소 위치를 기준으로 지도 범위를 재설정합니다
              	map.setBounds(bounds);
            }
            
            //검색결과 항목을 Element로 반환하는 함수입니다
            function getListItem(index, places) {
            
              	let el = document.createElement("li"),
              	itemStr = '<span class="markerbg marker_' + (index+1) + '"></span>' + 
              	'<div class="info">' + 
              	'   <h2>' + places.place_name + '</h5>';
            
              	if (places.road_address_name) {
                  	itemStr += '    <span>' + places.road_address_name + '</span>' + 
                  	'   <span class="jibun gray">' +  places.address_name  + '</span>';
              	} else {
                  	itemStr += '    <span>' +  places.address_name  + '</span>'; 
              	}
                           
            	itemStr += '  <span class="tel">' + places.phone  + '</span>' +
                          '</div>';           
            
              	el.innerHTML = itemStr;
              	el.className = 'item';
            
              	return el;
            }
            
            //마커를 생성하고 지도 위에 마커를 표시하는 함수입니다
        	function addMarker(position, idx, title) {
              	let imageSrc = 'https://t1.daumcdn.net/localimg/localimages/07/mapapidoc/marker_number_blue.png', // 마커 이미지 url, 스프라이트 이미지를 씁니다
                  	imageSize = new kakao.maps.Size(36, 37),  // 마커 이미지의 크기
                  	imgOptions =  {
                  	spriteSize : new kakao.maps.Size(36, 691), // 스프라이트 이미지의 크기
                  	spriteOrigin : new kakao.maps.Point(0, (idx*46)+10), // 스프라이트 이미지 중 사용할 영역의 좌상단 좌표
                  	offset: new kakao.maps.Point(13, 37) // 마커 좌표에 일치시킬 이미지 내에서의 좌표
              	},
              	markerImage = new kakao.maps.MarkerImage(imageSrc, imageSize, imgOptions),
                      marker = new kakao.maps.Marker({
                      position: position, // 마커의 위치
                      image: markerImage 
              	});
            
              	marker.setMap(map); // 지도 위에 마커를 표출합니다
              	markers.push(marker);  // 배열에 생성된 마커를 추가합니다
            
              	return marker;
            }
            
            //지도 위에 표시되고 있는 마커를 모두 제거합니다
            function removeMarker() {
              	for ( let i = 0; i < markers.length; i++ ) {
                  	markers[i].setMap(null);
              	}   
              	markers = [];
            }
            
            //검색결과 목록 하단에 페이지번호를 표시는 함수입니다
            function displayPagination(pagination) {
              	let paginationEl = $("#pagination")[0],
                  fragment = document.createDocumentFragment(); 
            
              	// 기존에 추가된 페이지번호를 삭제합니다
            	removeAllChildNods(paginationEl);
            
             for (let i=1; i<=pagination.last; i++) {
                  	let el = document.createElement("a");
                  	el.href = "#";
                  	el.innerHTML = i;
            
                  	if (i===pagination.current) {
                      	el.className = "on";
                  	} else {
                      	el.onclick = (function(i) {
                          	return function() {
                              	pagination.gotoPage(i);
                          	}
                      	})(i);
                  	}
            
                  	fragment.appendChild(el);
              	}
              	paginationEl.appendChild(fragment);
            }
            
            //검색결과 목록 또는 마커를 클릭했을 때 호출되는 함수입니다
            //인포윈도우에 장소명을 표시합니다
            function displayInfowindow(marker, title, list) {
              	let content = '<div style="padding:5px;z-index:1;">' + title + '</div>';
            
              	infowindow.setContent(content);
              	infowindow.open(map, marker);
              	if(list === true){
                  	map.setLevel(3);
                  	map.setCenter(marker.getPosition());
              	}
            }
            
            function removeAllChildNods(el) {   
              	while (el.hasChildNodes()) {
                  	el.removeChild (el.lastChild);
              	}
            }
        </script>
    </body>
</html>