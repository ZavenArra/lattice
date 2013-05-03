/*
---
description: Live search class that works on li and tr elements, recognizes up, down, enter, click commands.

license: MIT-style

authors:
- Troy Wolfe

requires:
- core: 1.2.4/Event
- core: 1.2.4/Class
- core: 1.2.4/Class.Extras
- core: 1.2.4/Element
- core: 1.2.4/Element.Event
- core: 1.2.4/Element.Style
- core: 1.2.4/DomReady

provides: [LLSearch]

...
*/

/*!
Live List Search for Mootools 1.2
copyright 2009 Troy Wolfe
*/

var LLSearch = new Class ({
	Implements: [Options, Events],
	options: {
		inputID: '', // the id of the live search input field
		listID: '', // the id of the ul, ol or table
		inResultsClass: 'LLS_inresults', 
		listType: 'li', // accepts li or tr
		preventClick: true,
		reFocus: true,
		currentSelection: 'LLS_current_selection', // the class of the current selection (should i make this ID?) 
		searchTerm: '', // class of element to search within tr, only used if listType == 'tr'
		searchTermLi: ''
		/*onEnter: $empty*/
		/*onClick: $empty*/
	},
	initialize: function(options) {		
		this.setOptions(options);
		this.inputName = $(this.options.inputID);
		this.setOptions(options);
		if (this.options.listType == 'tr') {
			this.searchEl = $$('#' + this.options.listID + ' ' + 'tbody ' + this.options.listType);
		}
		else {
			this.searchEl = $$('#' + this.options.listID + ' ' + this.options.listType);
		}
		this.searchEl.addClass(this.options.inResultsClass);
		this.currentListItem = -1;
		this.inList = $$('.' + this.options.inResultsClass);
		this.currentTextOnClick = '';
		this.currentLiveSearch= '';
		this.searchEvents = [];
		this.listClick();
		this.searchList();
		this.currentSelection = '';
	},
	
	listClick: function(){
		if(this.options.listType != 'tr') {
			this.inList.addEvent('click', function(e) {
				if(this.options.preventClick == true){
					e.preventDefault();
				}

				this.inList.removeClass(this.options.currentSelection);

				e.target.getParent('.' + this.options.inResultsClass).addClass(this.options.currentSelection);
				
				var currentTagEl = e.target.getParent('.' + this.options.inResultsClass);
				if(this.options.searchTermLi != ''){
					this.getCurrentText($(this.options.listID).getElement('.' + this.options.currentSelection).getElement('.' + this.options.searchTermLi));
				} else {
					this.getCurrentText($(this.options.listID).getElement('.' + this.options.currentSelection));		
				}
				
				if(this.options.reFocus == true){
					this.inputName.focus();			
				}
				
				this.fireEvent('click', [e, this.currentLiveSearch]);
			}.bind(this));	
		}
	},
	clearList: function(el){
		this.searchEl.removeClass(this.options.inResultsClass);	
	},
	getCurrentText: function(el){	
		this.currentLiveSearch = el.get('text');
	}, 
	
	getInputValue: function(){
		this.searchEvents.currentText = this.inputName.get('value').toLowerCase();
	},
	
	filterList: function(){
		this.getInputValue();
		this.searchEl.each(function(el){
			if (this.options.listType == 'tr') {
				this.searchEvents.currentWord = el.getElement('.' + this.options.searchTerm).get('text').toLowerCase();
			}
			else {
				if(this.options.searchTermLi != ''){
					this.searchEvents.currentWord = el.getElement('.' + this.options.searchTermLi).get('text').toLowerCase();
				} else {
					this.searchEvents.currentWord = el.get('text').toLowerCase();
				}
			}
			
			if(this.searchEvents.currentWord.contains(this.searchEvents.currentText)) {
				
				if (this.options.listType == 'tr') {
					el.setStyle('display', 'table-row').addClass(this.options.inResultsClass);
				}
				else {
					el.setStyle('display', 'block').addClass(this.options.inResultsClass);	
				}
				
				this.inList = $$('.' + this.options.inResultsClass); 
				
			} else {
				el.setStyle('display', 'none').removeClass(this.options.inResultsClass);
				this.inList = $$('.' + this.options.inResultsClass);
			}
			
			this.fireEvent('filter');
		}.bind(this));	
	},
	
	searchList: function(){

		this.inputName.addEvents({
			'keyup': function(e){
				this.filterList();
				if(e.key != 'down' && e.key != 'up' && e.key != 'enter' && e.key != 'left' && e.key != 'right') {
					this.currentListItem = -1;
					this.searchEl.removeClass(this.options.currentSelection);
				}
			}.bind(this),
			'keydown': function(e) {
				this.fireEvent('keydown', [e, this.currentLiveSearch]);
				
				if(e.key == 'down'){
					e.preventDefault();
					if(this.currentListItem != this.inList.length - 1) {
						
						this.currentListItem++;
						this.searchEl.removeClass(this.options.currentSelection);
						this.inList[this.currentListItem].addClass(this.options.currentSelection);
						this.scrollOnArrows();
					}
					
				} else if(e.key == 'up'){
					e.preventDefault();
					if(this.currentListItem > 0) {
						this.currentListItem--;
						this.searchEl.removeClass(this.options.currentSelection);
						this.inList[this.currentListItem].addClass(this.options.currentSelection);
						this.scrollOnArrows();
					}
					
				} else if(e.key == 'enter') {
					e.stopPropagation();
					e.preventDefault();
					this.cursorInList = this.inList.filter('.' + this.options.currentSelection);
					if(this.cursorInList != 0){
						
						if(this.options.searchTermLi != ''){
							this.getCurrentText($(this.options.listID).getElement('.' + this.options.currentSelection).getElement('.' + this.options.searchTermLi));
						} else {
							this.getCurrentText($(this.options.listID).getElement('.' + this.options.currentSelection));		
						}
					
						if(this.options.reFocus == true){
							this.inputName.focus();			
						}
					
						this.fireEvent('enter', [e, this.currentLiveSearch]);
					} else {

						this.getInputValue();
					}
				} 
			}.bind(this)
		});
	},
	
	scrollOnArrows: function() {
		this.currentPOS = $(this.options.listID).getElement('.' + this.options.currentSelection).getPosition(this.options.listID);
		$(this.options.listID).scrollTo(0, this.currentPOS.y);
	}
});
