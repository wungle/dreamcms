var DreamCMS = {
	init: function(){
		DreamCMS.initSelect2();
	},

	initSelect2: function() {
		$(".select2-icon-select").select2({
			allowClear: true,
			formatResult: DreamCMS.select2IconSelectFormatter,
		    formatSelection: DreamCMS.select2IconSelectFormatter,
		    escapeMarkup: function(m) { return m; }
		});
	},

	select2IconSelectFormatter: function(icon) {
		if (!icon.id) return icon.text; // optgroup
		return '<i class="'+ icon.id +'"></i> &nbsp; ' + icon.text;
	}
};

$(document).ready(function(){
	DreamCMS.init();
});