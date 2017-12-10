<script type="text/javascript" src="<?=base_url();?>app/js/js-xlsx/xlsx.core.min.js"></script>

<h3>Визначення термодинамічної стабільності рідких полімерних струменів</h3>
<div class="row">
	<div class="col-md-2">
		<div class="text-area-block">
			<div class="ta-label">
				<label>Діаметри волокон</label>
			</div>
			<div class="file-read">
				<label class="btn btn-block btn-primary" data-toggle="popover">
		            З файлу .txt .xlsx <input type="file" data-type="fibers" style="display: none;" accept=".txt, .xlsx">
		        </label>
	        </div>
	        <div class="ta">
				<textarea placeholder="Введіть значення" data-type="fibers">
1.3
1.3
1.4
1.3
1.2
1.4
1.3
				</textarea>
			</div>
			<div class="ta-label-count">
				Кількіть: <label data-type="fibers">0</label>
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="text-area-block">
			<div class="ta-label">
				<label>Значення частинок "а"</label>
			</div>
			<div class="file-read">
				<label class="btn btn-block btn-primary" data-toggle="popover">
		            З файлу .txt .xlsx <input type="file" data-type="a" style="display: none;" accept=".txt, .xlsx">
		        </label>
		    </div>
			<div class="ta">
				<textarea placeholder="Введіть значення" data-type="a">
1.3
1.1
1.7
1.9
1.4
1.3
				</textarea>
			</div>
			<div class="ta-label-count">
				Кількіть: <label data-type="a">0</label>
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="text-area-block">
			<div class="ta-label">
				<label>Значення частинок "лямбда"</label>
			</div>
			<div class="file-read">
				<label class="btn btn-block btn-primary" data-toggle="popover">
		            З файлу .txt .xlsx <input type="file" data-type="lyambda"  style="display: none;" accept=".txt, .xlsx">
		        </label>
		    </div>
			<div class="ta">
				<textarea placeholder="Введіть значення" data-type="lyambda">
1.3
1.3
1.4
2
4.3
1.4
1.3
				</textarea>
			</div>
			<div class="ta-label-count">
				Кількіть: <label data-type="lyambda">0</label>
			</div>
		</div>
	</div>
	<div class="col-md-6 text-center">
		<button type="button" id="calculate" class="btn btn-success">Розрахувати</button>
		<div id="result"></div>
	</div>
</div>

<script type="text/javascript">
	$(function(){
		pop_options = {
						html:true,
						trigger:'hover',
						placement:'bottom',
						content: 'Данні у файлі повинні бути введені кожен раз з нового рядка. В якості дробової коми можна використовувати "." та ","<br><b>Наприклад:</b><i><br>1.4<br>0.9<br>1.3</i>'
					};
		$('[data-toggle="popover"]').popover(pop_options);

		$(document).on('change', ':file', function() {
		    var file = this.files[0];
			var file_type = file.type;
			var type = $(this).data('type');
			var textarea = $('textarea[data-type="'+type+'"');
			var lines_count = 0;
			var text_line;

			$(textarea).val('');

	 		var reader = new FileReader();

	 		// READ .txt
	 		if(file_type == "text/plain"){
	 			reader.onload = function(progressEvent){
			    	
					var lines = this.result.split('\n');
			    	for(var line = 0; line < lines.length; line++){

			    		text_line = lines[line].trim().replace(',','.');

			    		if(text_line != ""){
			    			$(textarea).val(textarea.val() + text_line);
			    			lines_count++;

			    			if(line != lines.length-1){
				    			$(textarea).val(textarea.val() + "\n");
				    		}
			    		}
			    	}
			    	$(textarea).val(textarea.val().trim());
			    	$('label[data-type="'+type+'"').text(lines_count);
		    	}
		    	reader.readAsText(file);
	 		}

	 		// READ .xmlx
	 		if(file_type == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"){
				reader.onload = function (e) {
	                var data = e.target.result;

	                var result;
	                var workbook = XLSX.read(data, { type: 'binary' });
	                
	                var sheet = workbook.SheetNames[0];
                    var lines = XLSX.utils.sheet_to_json(workbook.Sheets[sheet], {header:1});
                    for(var line = 0; line < lines.length; line++){

			    		text_line = lines[line][0].trim().replace(',','.');

			    		if(text_line != ""){
			    			$(textarea).val(textarea.val() + text_line);
			    			lines_count++;

			    			if(line != lines.length-1){
				    			$(textarea).val(textarea.val() + "\n");
				    		}
			    		}
			    	}
			    	$(textarea).val(textarea.val().trim());
			    	$('label[data-type="'+type+'"').text(lines_count);
	            };
	            reader.readAsArrayBuffer(file);
	 		}
		});

		$('#calculate').on('click',function(){
			var json = {};

			json.array_fiber = get_array_from_textarea($('textarea[data-type="fibers"'));
			json.array_a = get_array_from_textarea($('textarea[data-type="a"'));
			json.array_lyambda = get_array_from_textarea($('textarea[data-type="lyambda"'));

			$.post("calculate", json, function(data){
				$('#result').html(data);
			});
		});
	});

	function get_array_from_textarea(textarea){
		var text = $(textarea).val().trim();
		var array = text.split('\n');

		return array;
	}
</script>