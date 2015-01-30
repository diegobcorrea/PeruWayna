<?php 
			echo'<div id="tagFields">';
			$tagFields = get_post_meta($post->ID, $meta_box['name'].'_value',true);

			$c = 1;
			$d = 1;
			if ($tagFields != ''){
				foreach($tagFields as $tag ){
					echo Print_mapwdetail_fields($meta_box['name'].'_value',$c,$tag['img'],$tag['imgzoom'],$tag['x'],$tag['y'],$tag['w'],$tag['h'],$tag['static'],$tag['d']);
					$c = $c +1;
				}
			}
			echo'</div>';
			echo'<span id="here"></span>';
			
			?>
			<script>
	        var $ =jQuery.noConflict();

            $(document).ready(function() {
            
	            if ( $('.dynamicField:first input:first').val() == '' ){
	            	$('.dynamicField:first .remove').hide();
	            };
	            
	            $('.dynamicField:first').find('input:first').change(function() {
	            	if ( $('.dynamicField:first input:first').val() == '' ){
	            		$('.dynamicField:first .remove').hide();
	            	}
	            	else {
	            		$('.dynamicField:first .remove').show();
	            	}
	            });
	            
	            $('.dynamicField:first').find('.upload_img').click(function() {
	            	if ( $('.dynamicField:first input:first').val() == '' ){
	            		$('.dynamicField:first .remove').show();
	            	}
	            });
	            
	            var count = <?php echo $c; ?>;

	            var dp = $('#map-container');

			    dp
			     .css({ position: 'relative' })
			     .on("mousemove mousedown mouseup", draw_a_box );

			    draw = false;

	            $('#map-container').click(function(e){
					var offset = $(this).offset(),
						center = 19.5,
						a = $("#"+count+".drawnBox").position().left,
				    	b = $("#"+count+".drawnBox").position().top,
				    	h = $(this).height(),
				    	w = $(this).width(),
				    	percentX = ( a / w * 100 ),
				    	percentY = ( b / h * 100 ),
				    	W = $("#"+count+".drawnBox").width() + 2,
				    	H = $("#"+count+".drawnBox").height() + 2;
				    	percentW = ( W / w * 100 ),
				    	percentH = ( H / h * 100 ),
					
					$('#tagFields').append('<?php echo implode('',explode("\n",Print_mapwdetail_fields($meta_box["name"]."_value", 'count'))); ?>'.replace(/count/g, count));

					$("#tag-"+count+" #tagX").val(percentX);
					$("#tag-"+count+" #tagY").val(percentY);
					$("#tag-"+count+" #tagW").val(percentW);
					$("#tag-"+count+" #tagH").val(percentH);

					pexetoPageOptions.loadUploadFunctionality();

					var dcnt = 1
		            $(".add").click(function() {
						var dataID = $(this).data("id");

		                $("#tag-"+dataID+" .details").append(('<?php echo implode('',explode("\n",Print_tagwdetail_product_fields($meta_box["name"]."_value", 'dataID','dcnt'))); ?>'.replace(/dataID/g, dataID).replace(/dcnt/g, dcnt)));
		                dcnt = dcnt + 1;
		                return false;
		            });

		            count = count + 1;
					return false;
				});

	            $(".add").click(function() {
	            	var dataID = $(this).data("id"),
						num = $("#tag-"+dataID+" .details .dynamicBox").length;

	                $("#tag-"+dataID+" .details").append(('<?php echo implode('',explode("\n",Print_tagwdetail_product_fields($meta_box["name"]."_value", 'dataID','num'))); ?>'.replace(/dataID/g, dataID).replace(/num/g, num)));
					num = num + 1;
	                return false;
	            });

	            $(".remove").live('click', function() {
	            	var id = $(this).data('id');

	                $("#tag-"+id).remove();
	                $("#"+id+".drawnBox").remove();
	            });

	            $(".remove-det").live('click', function() {
	            	var id = $(this).data('id'),
	            		cnt = $(this).data('container');;

	                $("#tag-"+cnt+" #detail-"+id).remove();
	            });

	            function draw_a_box( e ) {
		    
				    var scrollTop = $(window).scrollTop(),
				        elementOffset = dp.offset().top,
				        elementOffsetLeft = dp.offset().left,
				        distance = (elementOffset - scrollTop),
				        pageX = e.pageX - elementOffsetLeft,
				        pageY = e.pageY - elementOffset,
				        dpLast = dp.find('.drawnBox.last'),
				        dpLast_data = dpLast.data();
				    
				    if ( e.type === 'mousemove' ) {
				        
				        // If ".drawnBox.last" doesn't exist, create it.
				        if ( dpLast.length < 1 ) {
				            $('<a id="'+count+'" class="drawnBox last"></a>').appendTo( dp );
				        }
				        
				        var drawCSS = {};

				        // If drawing is initiated.
				        if ( draw ) {

				            // Determine the direction.
				            
				            // xLeft
				            if ( dpLast_data.pageX > pageX ) {
				                drawCSS['right'] = dp.width() - dpLast_data.pageX,
				                drawCSS['left'] = 'auto',
				                drawCSS['width'] = dpLast_data.pageX - pageX;
				            }
				            // xRight
				            else if ( dpLast_data.pageX < pageX ) {
				                drawCSS['left'] = dpLast_data.pageX,
				                drawCSS['right'] = 'auto',
				                drawCSS['width'] = pageX - dpLast_data.pageX;
				            }
				            
				            // yUp
				            if ( dpLast_data.pageY > pageY ) {
				                drawCSS['bottom'] = dp.height() - dpLast_data.pageY,
				                drawCSS['top'] = 'auto',
				                drawCSS['height'] = dpLast_data.pageY - pageY;
				            }
				            // yDown
				            else if ( dpLast_data.pageY < pageY ) {
				                drawCSS['top'] = dpLast_data.pageY,
				                drawCSS['bottom'] = 'auto',
				                drawCSS['height'] = pageY - dpLast_data.pageY;
				            }

				        }

				        if ( !draw && dpLast.length > 0 ) {

				            dpLast.css({
				                top: pageY,
				                left: pageX
				            });
				        }
				        
				        if ( draw ) {
				            dpLast.css( drawCSS );
				        } 
				        
				    }

				    if ( e.type === 'mousedown' ) {

				        e.preventDefault();
				        draw = true;
				        dpLast.data({ "pageX": pageX, "pageY": pageY });      
				        
				    }
				    else if ( e.type === 'mouseup' ) {

				        draw = false;
				        dpLast.removeClass('last');

				    }
				}

	        });
		    </script>
			<?