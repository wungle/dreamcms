var DreamCMS = {
	captchaReloadCount: 0,

	init: function(){
		DreamCMS.refreshCaptcha();
		DreamCMS.initSelect2();
		DreamCMS.adminResetAcl();
	},

	refreshCaptcha: function() {
		$('.secret-captcha-reload').click(function(){
			DreamCMS.captchaReloadCount = DreamCMS.captchaReloadCount + 1;
			$('.secret-captcha').attr('src', '/secret/captcha/' + DreamCMS.captchaReloadCount);
			console.log('captchaReloadCount: ' + DreamCMS.captchaReloadCount);
		});
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
	},

	adminResetAcl: function() {
		$('#AdminGroupId').change(function(){
			var group_id = $(this).val();
			$.get('/dreamcms/admins/reset_acl/' + group_id, function(data) {
				data = $.trim(data);
				$('#AdminACLTable').empty().html(data);
			});
		});
	}
};

$(document).ready(function(){
	DreamCMS.init();
});