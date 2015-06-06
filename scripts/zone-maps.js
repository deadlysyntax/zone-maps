(function()
{

	// Initialises
    function MapZones(config)
	{
		try
		{
			this.init(config);	
		}
		catch(e)
		{
			throw new Error(e.message);
		}
    }



	//
    MapZones.prototype.init = function(config)
	{
		//
		this.config.init(config);
		
		//
		this.view.init(this);
    };



// Gets, Sets and holds our portrayal configuration
    MapZones.prototype.config = {
		items: {
			'map_data':                     {},
			'container':                    '',
			'map_width':                    960,
			'map_height':                   640,
			'zone_overlay_colour':          '#FFFFFF',
			'zone_overlay_rollover_colour': '#EFAE00',
			'zone_fill_opacity':            0.8,
			'zone_stroke_color':            '#EFAE00',
			'zone_stroke_width':            1,
			'zone_stroke_opacity':          1,
			'zone_circle_radius':           12,
			'zone_font_color':              '#423F3F',
			'zone_font_family':             'arial, helvetica, sans-serif',
			'zone_font_size':               '14px',
			'zone_font_weight':             'bold',
			'current_opened_zone':          null,
			'zone_legend_rollover_color':   '#EFAE00',
			'zone_legend_color':            '#423F3F',
			'zone_font_opacity':            1
		},

		init: function(config)
		{
			for (var key in config)
				this.set(key, config[key]);
		},

		get: function(key)
		{
			if (this.items[key] === undefined)
				throw new Error(key + ' configuration item does not exist');
			else
				return this.items[key];
		},

		set: function(key, value)
		{
			if (this.items[key] === undefined)
				throw new Error(key + ' is not a valid configuration option');
			else
				this.items[key] = value;
		}
    };




	MapZones.prototype.view = {
		
		init: function(entity)
		{
			//
			var data = entity.config.get('map_data');

			// Set up html structure of maps
			$( entity.config.get('container') ).append('<div id="map_region"></div><div class="legend_region"></div>' );
			
			// Apply background image to the container
			$( '.map_region' ).css({ 'width': entity.config.get('map_width') + 'px', 'height': entity.config.get('map_height') + 'px' });
			
			// Initialise raphaeljs
			var map = Raphael( 'map_region', entity.config.get('map_width'), entity.config.get('map_height') );
			
			// Load the map image
			map.image( data.map_image_url , 0, 0, entity.config.get('map_width'), entity.config.get('map_height'));
			
			// Add zones to the map and the legend
			entity.view.add_zones_to_map( data.map_zones, map, entity );
			
			
			MapZones.prototype.map = map;
			
			
		},
		
		add_zones_to_map: function( map_zones, map_object, entity )
		{
			
			/*
				Build the legend
			*/
			$('<ol class="map_legend"></ol>').appendTo('.legend_region');
			
			/*
				Operate on each zone
			*/
			for(i=0; i < map_zones.length; i++)
			{
				/*
					Draw zone area on to map
				*/
				entity.view.draw_zone( i, map_zones[i], map_object, entity );

				/*
					Add items to the legend
				*/
				entity.view.add_item_to_legend( i, map_zones[i], map_object, entity );
			}	
		},
		
		
		
		/**
			
			
		**/
		draw_zone: function( key, map_zone, map_object, entity )
		{
			
			/*
				
			*/
			//var zone = entity.view.draw_numbered_circle( key, map_zone.zone_x_coordinate, map_zone.zone_y_coordinate, entity.config.get('zone_circle_radius'), map_object, entity )
			
			var zone = entity.view.draw_shape( map_zone, map_object, entity );
			
			
			// Hover state
			zone.hover(function(e)
			{
				entity.view.zone_hover_on( zone, entity );
				// Highlight the legend
				$('#zone_' + key +' a.zone_content_toggle').css({color: entity.config.get('zone_legend_rollover_color') });
			},
			function(e)
			{
				entity.view.zone_hover_off( zone, entity );
				// Highlight the legend
				$('#zone_' + key + ' a.zone_content_toggle').css({ color: entity.config.get('zone_legend_color') });
			})
			
			// Click state
			zone.click(function()
			{
				//
				entity.view.toggle_zone_data( key, entity );
				
			});
			
			zone.node.id = key;
		},
		
		
		
		
		/**
			
			
		**/
		add_item_to_legend: function( key, map_zone, map_object, entity )
		{
			/*
			
			*/
			var html = '<li id="zone_'+ key +'"><a href="#" class="zone_content_toggle" data-zone-key="'+ key +'">' + map_zone.zone_title + '</a>';
			
			html    += '<div id="zone_'+ key +'_content" class="zone_content"><a href="#" class="close_zone_content" data-zone-key="'+ key +'">Close</a><h2>' + map_zone.zone_title + '</h2>' + map_zone.content + '</div>';
			
			html    += '</li>';
			
			$('.map_legend').append(html);
			
			
		},
		
		
		
		/*
			Place a numbered circle over the top of the map, corresponding to the legend
		*/
		draw_numbered_circle: function( key, x, y, radius, map_object, entity )
		{
			// Set
		//	var set = map_object.set()
			
			
			var circle  = map_object.circle( x, y, radius ).attr(
			{ 
				"fill":           entity.config.get('zone_overlay_colour'), 
				"stroke":         entity.config.get('zone_stroke_color'), 
				"fill-opacity":   entity.config.get('zone_fill_opacity'),
				"stroke-width":   entity.config.get('zone_stroke_width'),
				"stroke-color":   entity.config.get('zone_stroke_color'),
				"stroke-opacity": entity.config.get('zone_stroke_opacity'),
				//"text":           text,
				"cursor":         "hand"
			});
			
			var text    = map_object.text( x, y, ( key + 1 ).toString() ).attr(
			{
				"fill":           entity.config.get('zone_font_color'),
				"fill-opacity":   entity.config.get('zone_font_opacity'),
				"font-family": 	  entity.config.get('zone_font_family'),
				"font-size":      entity.config.get('zone_font_size'),
				"font-weight":    entity.config.get('zone_font_weight')
			}).toFront();
			
			
			//set.push(circle);
			//set.push(text);
			return circle;//set;
		},
		
		
		
		draw_shape: function( map_zone, map_object, entity )
		{
			/*
				Convert polygon points to an svg path
				http://stackoverflow.com/questions/9690241/rendering-svg-polygons-in-raphael-javascript-library
			*/
			var polygonPoints = map_zone.zone_vector_coordinates;
			var converted_path = polygonPoints.replace(/([0-9.]+),([0-9.]+)/g, function($0, x, y) {
			    return 'L ' + Math.floor(x) + ',' + Math.floor(y) + ' ';
			}).replace(/^L/, 'M'); // replace first L with M (moveTo)
			// Create element
			var zone = map_object.path( converted_path ).attr(
			{ 
				'x':              map_zone.zone_x_coordinate, 
				'y':              map_zone.zone_y_coordinate,
				'fill':           entity.config.get('zone_overlay_colour'),
				'fill-opacity':   entity.config.get('zone_fill_opacity'),
				'stroke-width':   entity.config.get('zone_stroke_width'),
				'stroke':         entity.config.get('zone_stroke_color'),
				'stroke-opacity': entity.config.get('zone_stroke_opacity')
			});
			return zone;
		},
		
		
		
		/**
			Show or hide the content for a particular zone
			
		*/
		toggle_zone_data: function( key, entity )
		{
			
			// Check if there is one open already
			var already_open = entity.config.get('current_opened_zone');
			
			// This means no zone-content is currently showing
			if( already_open == null )
			{
				$('#zone_'+ key +'_content').show();
				entity.config.set( 'current_opened_zone', key );
			}
			// There is currently some content open
			else
			{
				// Check out whether it's the same one trying to open again
				if( already_open == key )
				{
					// Leave as is
				}
				else
				{
					// Hide what's showing
					$('#zone_'+ already_open +'_content').hide();
					// Set the current_opened_zone to the new one
					entity.config.set( 'current_opened_zone', key );
					// Show the new one
					$('#zone_'+ key +'_content').show();
				}	
			}
		},
		
		
		close_zone_content: function( element, entity )
		{
			//
			var key   = $(element).attr('data-zone-key');
			//
			$('#zone_'+ key +'_content').hide();
			entity.config.set( 'current_opened_zone', null );
		},
		
		
		
		find_element_from_outside: function( element, entity )
		{
			//
			var key   = $(element).attr('data-zone-key');
			var el_id = null;
			//
			entity.map.forEach(function(el)
			{
				if( key.toString() == el.node.id.toString() )
					el_id = el.id;
			});
			// returns the 
			return entity.map.getById( el_id );
		},
		
		
		zone_hover_on: function( zone, entity )
		{
			// Highlight the zone
			zone.attr({ 'fill': entity.config.get('zone_overlay_rollover_colour') });
				
		},
		
		zone_hover_off: function( zone, entity )
		{
			zone.attr({ 'fill': entity.config.get('zone_overlay_colour') });
		}
		
		
	};

	/* */
	window.MapZones = MapZones;
})();





/**
	Event handlers associated with MapZones
**/
jQuery(function(){
	
	
	/*
	
	*/
	$('.zone_content_toggle').on('click', function(e)
	{
		e.preventDefault();
		// Get the key id of the clicked element
		var key = $(this).attr('data-zone-key');
		//
		map_zones.view.toggle_zone_data( key, map_zones );
	});
	
	
	/*
	
	*/
	$('.close_zone_content').on('click', function(e)
	{
		e.preventDefault();
		//
		map_zones.view.close_zone_content( this, map_zones );
		
	});
	
	
	/*
	
	*/
	$('.zone_content_toggle').hover(function(e)
	{	
		//
		var zone = map_zones.view.find_element_from_outside( this, map_zones);
		//
		map_zones.view.zone_hover_on( zone, map_zones );
	},
	function(e)
	{
		//
		var zone = map_zones.view.find_element_from_outside( this, map_zones);
		//
		map_zones.view.zone_hover_off( zone, map_zones );
	});
	
	
	
	
	
});
