var DataFinderCounter = 900;
var DataFinder = {
	fieldValues: null,
	fieldNames: null,

	initialize: function() {
		this.formToggler();
		this.addConditions();
		this.deleteConditions();
	},

	init: function(names, values) {
		DataFinder.fieldNames = names;
		DataFinder.fieldValues = values;
	},

	formToggler: function() {
		$('#DataFinderContainer').hide();
		$('#DataFinderControl').hide();

		$('#DataFinderToggler').click(function(e){
			$(this).hide();
			$('#DataFinderContainer').show();
			$('#DataFinderControl').show();

			e.stopPropagation();
			return false;
		});

		$('#DataFinderCancel').click(function(e){
			$('#DataFinderContainer').hide();
			$('#DataFinderControl').hide();
			$('#DataFinderToggler').show();

			e.stopPropagation();
			return false;
		});
	},

	addConditions: function() {
		$('#DataFinderAdd').click(function(e){
			var elements = '';
			elements = elements + '<div class="dfrow">';
			elements = elements + '<select name="data[DataFinder]['+ DataFinderCounter +'][field]" class="form-control dfinput">';

			for (var i=0; i<DataFinder.fieldValues.length; i++)
				elements = elements + '<option value="'+ DataFinder.fieldValues[i] +'">'+ DataFinder.fieldNames[i] +'</option>';

			elements = elements + '</select> ';
			elements = elements + '<select name="data[DataFinder]['+ DataFinderCounter +'][op]" class="form-control dfinput">';
			elements = elements + '<option value="=">=</option>';
			elements = elements + '<option value="&gt;">&gt;</option>';
			elements = elements + '<option value="&lt;">&lt;</option>';
			elements = elements + '<option value="&gt;=">&gt;=</option>';
			elements = elements + '<option value="&lt;=">&lt;=</option>';
			elements = elements + '<option value="like">Contain</option>';
			elements = elements + '</select> ';
			elements = elements + '<input type="text" name="data[DataFinder]['+ DataFinderCounter +'][value]" class="form-control dfinput" /> ';
			elements = elements + '<a href="javascript:void(0);" class="btn btn-danger" onclick="javascript:return DataFinder.deleteConditions(this);">&times;</a> ';
			elements = elements + '</div>';

			$('#DataFinderContainer').append(elements);

			DataFinderCounter++;

			e.stopPropagation();
			return false;
		});
	},

	deleteConditions: function(element) {
		if (DataFinder.countConditions() > 2)
			$(element).parent().remove();

		return false;
	},

	preCondition: function(fieldValue, operation, keyword) {
		var elements = '';
		elements = elements + '<div class="dfrow">';
		elements = elements + '<select name="data[DataFinder]['+ DataFinderCounter +'][field]" class="form-control dfinput">';

		for (var i=0; i<DataFinder.fieldValues.length; i++)
		{
			if (DataFinder.fieldValues[i] == fieldValue)
				elements = elements + '<option value="'+ DataFinder.fieldValues[i] +'" selected>'+ DataFinder.fieldNames[i] +'</option>';
			else
				elements = elements + '<option value="'+ DataFinder.fieldValues[i] +'">'+ DataFinder.fieldNames[i] +'</option>';
		}

		elements = elements + '</select> ';
		elements = elements + '<select name="data[DataFinder]['+ DataFinderCounter +'][op]" class="form-control dfinput">';
		
		if (operation == '=')
			elements = elements + '<option value="=" selected>=</option>';
		else
			elements = elements + '<option value="=">=</option>';

		if (operation == '&gt;')
			elements = elements + '<option value="&gt;" selected>&gt;</option>';
		else
			elements = elements + '<option value="&gt;">&gt;</option>';

		if (operation == '&lt;')
			elements = elements + '<option value="&lt;" selected>&lt;</option>';
		else
			elements = elements + '<option value="&lt;">&lt;</option>';
		
		if (operation == '&gt;=')
			elements = elements + '<option value="&gt;=" selected>&gt;=</option>';
		else
			elements = elements + '<option value="&gt;=">&gt;=</option>';

		if (operation == '&lt;=')
			elements = elements + '<option value="&lt;=" selected>&lt;=</option>';
		else
			elements = elements + '<option value="&lt;=">&lt;=</option>';

		if (operation == 'like')
			elements = elements + '<option value="like" selected>Contain</option>';
		else
			elements = elements + '<option value="like">Contain</option>';
		
		elements = elements + '</select> ';
		elements = elements + '<input type="text" name="data[DataFinder]['+ DataFinderCounter +'][value]" class="form-control dfinput" value="'+ keyword +'" /> ';
		elements = elements + '<a href="javascript:void(0);" class="btn btn-danger" onclick="javascript:return DataFinder.deleteConditions(this);">&times;</a> ';
		elements = elements + '</div>';

		$('#DataFinderContainer').append(elements);

		DataFinderCounter++;
	},

	countConditions: function() {
		var counter = 0;
		$('#DataFinderContainer').find('.dfrow').each(function(){
			counter++;
		});

		return counter;
	}
};

$(document).ready(function(){
	DataFinder.initialize();
});