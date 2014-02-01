var DreamCMS = {
	captchaReloadCount: 0,
	loadTraceLogUrl: '',
	traceLogOffset: 0,

	init: function(){
		DreamCMS.refreshCaptcha();
		DreamCMS.initSelect2();
		DreamCMS.adminResetAcl();
		DreamCMS.initFileInput();
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
	},

	initFileInput: function() {
		$('.ace-fileinput').ace_file_input({
			no_file:'No File ...',
			btn_choose:'Choose',
			btn_change:'Change',
			droppable:false,
			onchange:null,
			thumbnail:false //| true | large
			//whitelist:'gif|png|jpg|jpeg'
			//blacklist:'exe|php'
			//onchange:''
			//
		});
	},

	loadTraceLog: function(url) {
		if (url == undefined)
			url = DreamCMS.loadTraceLogUrl;
		else
			DreamCMS.loadTraceLogUrl = url;

		$.ajax({
			url: url + DreamCMS.traceLogOffset,
			dataType: 'json',
			success: function (result, status) {
				DreamCMS.traceLogOffset = DreamCMS.traceLogOffset + result.count;

				var newElements = '';
				for (var i=0; i<result.count; i++)
				{
					var avatar = '/theme/AceAdmin/avatars/unknown-user.jpg';

					if (result.data[i].CmsLog.admin.has_gravatar_account)
						avatar = result.data[i].CmsLog.admin.avatar;

					newElements = newElements + '<div class="itemdiv dialogdiv"><div class="user">';
					newElements = newElements + '<img alt="avatar" src="'+ avatar +'" />';
					newElements = newElements + '</div><div class="body"><div class="time"><i class="icon-time"></i>';
					newElements = newElements + ' &nbsp; <span class="orange">'+ result.data[i].CmsLog.created +'</span></div>';
					newElements = newElements + '<div class="name"><a href="'+ result.data[i].CmsLog.url +'">'+ result.data[i].CmsLog.admin.real_name +'</a>';
					newElements = newElements + ' &nbsp; <span class="label label-info arrowed arrowed-in-right">'+ result.data[i].CmsLog.admin.username +'</span></div>';
					newElements = newElements + '<div class="text"><p><b>'+ result.data[i].CmsLog.operation +'</b></p></div>';
					newElements = newElements + '<div class="text"><p>'+ result.data[i].CmsLog.description +'</p></div>';
					newElements = newElements + '<div class="text"><p><b>Affected fields:</b><br />'+ result.data[i].CmsLog.fields +'</p></div>';
					newElements = newElements + '<div class="tools"><a href="'+ result.data[i].CmsLog.url +'" class="btn btn-minier btn-info"><i class="icon-only icon-eye-open"></i></a>';
					newElements = newElements + '</div></div></div>';
				}

				if (result.count == 0)
				{
					$('#recordHistoryLoadMore').hide();
					if (DreamCMS.traceLogOffset == 0)
					{
						newElements = newElements + '<div class="itemdiv dialogdiv"><div class="user">';
						newElements = newElements + '&nbsp;';
						newElements = newElements + '</div><div class="body"><div class="time">';
						newElements = newElements + '&nbsp;</div>';
						newElements = newElements + '<div class="text"><p>Sorry, we can not find any logs related to this record.</p></div>';
						newElements = newElements + '</div></div>';
					}
				}

				$('#recordHistoryContent').append(newElements);

				//console.log(result);
			},
			error: function (data, status, e) {
				console.log(e);
			}
		});
	}
};

$(document).ready(function(){
	DreamCMS.init();
});