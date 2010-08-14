mop.modules.GoLive = new Class({

	Extends: mop.modules.Module,
	
	initialize: function( anElement, aMarshal ){
		this.parent( anElement, aMarshal );
		this.message = this.element.getElement(".message");
		this.boolSwitch = new mop.ui.SlideSwitch( this.element.getElement(".SlideSwitch"), this, {
			label_position: "inside",
			hide_labels: false,
			hide_radios: true,
			drag_opacity: .7,
			onChange: function( val ){
				this.onSwitch( val );
			}.bind( this )
		});

		this.bigRedButton = anElement.getElement("#bigRedButton");
		this.bigRedButton.addEvent( "click", this.onClick.bindWithEvent( this ) );
		this.spinner = anElement.getElement(".spinner");
	},

	onClick: function( e ){
		if( e && e.preventDefault ){
			e.preventDefault();
		}else if( e ){
			e.returnVal = false;
		}		
		this.message.set( "text", "" ); 
		var dialogue = confirm("You are about to publish the staged content onto the live server. Are you certain you want to do this, it cannot be undone?");
		if( dialogue ){
			this.spinner.removeClass("hidden");
			this.JSONSend( "copytolive", null, { onComplete: this.onComplete.bind( this ) });
		}
	},
	
	onComplete: function( json ){
		if( json.response == true ){
			this.spinner.addClass("hidden");
			this.boolSwitch.deActivate();
			this.message.set( "text", "Staging changes have been successfully pushed to the live server." );
			this.bigRedButton.addClass("hidden");			
		}else{
			this.spinner.addClass("hidden");
			this.boolSwitch.deActivate();
			this.message.set( "text", "Something went wrong, please contact your admin." );
			this.bigRedButton.addClass("hidden");			
		}
	},
	
	onSwitch: function( val ){
		if( val == true ){
			this.message.set( "text", "" ); 
			this.bigRedButton.removeClass("hidden");
		}else{
			this.bigRedButton.addClass("hidden");
		}
	}
	
});

