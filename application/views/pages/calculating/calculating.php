<script type="text/javascript" src="<?=base_url();?>app/js/js-xlsx/xlsx.core.min.js"></script>

<h3>Визначення термодинамічної стабільності рідких полімерних струменів</h3>
<div class="row">
	<div class="col-md-2 offset-md-3">
		<div class="file-read">
			<label class="btn btn-block btn-primary" data-toggle="popover">
		        Завантажити з файлу .xlsx <input type="file" id="file" data-type="fibers" style="display: none;" accept=".txt, .xlsx">
		    </label>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-2">
		<div class="text-area-block">
			<div class="ta-label">
				<label>Діаметри волокон</label>
			</div>
	        <div class="ta">
				<textarea placeholder="Введіть значення" data-type="fibers" data-sheet="0"></textarea>
			</div>
			<div class="ta-label-count">
				Кількіть: <label data-type="fibers" data-sheet="0">0</label>
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="text-area-block">
			<div class="ta-label">
				<label>Значення частинок "а"</label>
			</div>
			<div class="ta">
				<textarea placeholder="Введіть значення" data-type="a" data-sheet="1"></textarea>
			</div>
			<div class="ta-label-count">
				Кількіть: <label data-type="a" data-sheet="1">0</label>
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="text-area-block">
			<div class="ta-label">
				<label>Значення частинок "лямбда"</label>
			</div>
			<div class="ta">
				<textarea placeholder="Введіть значення" data-type="lyambda" data-sheet="2"></textarea>
			</div>
			<div class="ta-label-count">
				Кількіть: <label data-type="lyambda" data-sheet="2">0</label>
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="text-area-block">
			<div class="ta-label">
				<label>Час</label>
			</div>
			<div class="ta">
				<textarea placeholder="Введіть значення" data-type="time" data-sheet="3"></textarea>
			</div>
			<div class="ta-label-count">
				Кількіть: <label data-type="time" data-sheet="3">0</label>
			</div>
		</div>
	</div>
	<div class="col-md-4 text-center">
		<div class="clear-btn">
			<span class="float-right" id="clear">Очистити</span>
		</div>
		<div class="step-block" data-step="step_1">
			<p><b>Крок 1: Знаходимо коефіцієнт нестабільності струменя</b></p>
			<p>Розрахунковий діаметр d0: <input type="text" id="d0" name="d0" class='form-control var-input'></p>
			<button type="button" class="btn btn-success calculate" data-step="step_1">Розрахувати</button>
			<div class="result" data-step="step_1"></div>
		</div>
		<div class="step-block hidden" data-step="step_2">
			<p><b>Крок 2: Знаходимо хвильове число, та співвідношення в'язкозтей фаз</b></p>
			<p>ƞ1: <input type="text" id="eta1" name="eta1" class='form-control var-input'></p>
			<p>ƞ2: <input type="text" id="eta2" name="eta2" class='form-control var-input'></p>
			<button type="button" class="btn btn-success calculate hidden" data-step="step_2">Розрахувати</button>
			<div class="result" data-step="step_2"></div>
		</div>
		<div class="step-block hidden" data-step="step_3">
			<p><b>Крок 3: Вводимо з теоретичної кривої значення Ω(ꭙ,ρ), та знаходимо поверхневий натяг</b></p>
			<p>Ω: <input type="text" id="omega" name="omega" class='form-control var-input'></p>
			<button type="button" class="btn btn-success calculate hidden" data-step="step_3">Розрахувати</button>
			<div class="result" data-step="step_3"></div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function(){
		pop_options = {
						html:true,
						trigger:'hover',
						placement:'bottom',
						content: 'Данні у файлі повинні розміщуватися на чотирьох литах. Імена листів не мають значення.</br><b>Порядок листів:</b></br><i>1 - діаметри волкон</br>2 - зачення частинок "а"</br>3 - значення лямбда</br>4 - час</i>'
					};
		$('[data-toggle="popover"]').popover(pop_options);

		$(document).on('change', ':file', function() {
		    var file = this.files[0];
			var file_type = file.type;
			var type = $(this).data('type');
			var textarea = $('textarea[data-type="'+type+'"');

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
	                if(workbook.SheetNames.length == 4){
	                	for(sheet_index = 0; sheet_index < 4; sheet_index++){
	                		
	                		var textarea = $('textarea[data-sheet="'+sheet_index+'"');
	                		var lines_count = 0;
							var text_line = "";

	                		var sheet = workbook.SheetNames[sheet_index];
			               	var ref = workbook.Sheets[sheet]['!ref'];

			               	var start_ref = ref.match(/^[A-Z]+/)[0];
			               	var start_n_ref = ref.match(/([0-9]+):/)[1];
			               	var end_ref = ref.match(/:([A-Z]+)/)[1];
			               	var end_n_ref = ref.match(/([0-9]+)$/)[1];
			               	var i = 0;

			               	do{
			               		workbook.Sheets[sheet]['!ref'] = start_ref + start_n_ref + ":" + start_ref + end_n_ref;

			               		var lines = XLSX.utils.sheet_to_json(workbook.Sheets[sheet], {header:1});
			                    for(var line = 0; line < lines.length; line++){

						    		text_line = lines[line][i].trim().replace(',','.');

						    		if(text_line != ""){
						    			if(sheet_index == 0 && line == 0 && start_ref == "A")
						    				$('#d0').val(text_line);
						    			$(textarea).val(textarea.val() + text_line);
						    			lines_count++;

										$(textarea).val(textarea.val() + "\n");
						    		}
						    	}
						    	$('label[data-sheet="'+sheet_index+'"').text(lines_count);
					    		i++;
			               		start_ref = String.fromCharCode(start_ref.charCodeAt(0)+1);
			               	}while(start_ref != end_ref);
			               
		               		$(textarea).val(textarea.val().trim());
	                	}
	                }else{
	                	alert('Помилка зчитування. Файл повинен містити чотири Листа')
	                }
	               
	            };
	            reader.readAsArrayBuffer(file);
	 		}
		});

		$('.calculate').on('click',function(){
			var step = $(this).data('step');
			var json = {step:step};

			json.array_fiber = get_array_from_textarea($('textarea[data-type="fibers"'));
			json.array_a = get_array_from_textarea($('textarea[data-type="a"'));
			json.array_lyambda = get_array_from_textarea($('textarea[data-type="lyambda"'));
			json.array_time = get_array_from_textarea($('textarea[data-type="time"'));
			json.d0 = $('#d0').val();
			json.eta1 = $('#eta1').val();
			json.eta2 = $('#eta2').val();
			json.omega = $('#omega').val();

			if(step == "step_1" 
				&& (json.array_fiber.length == 0 
					|| json.array_a.length == 0 
					|| json.array_lyambda.length == 0 
					|| json.array_time	.length == 0)){
				alert("Некоректні вхідни дані");
				return;
			}

			if(step == 'step_1'){
				$(this).addClass("hidden");
				$('[data-step="step_2"]').removeClass('hidden');
			}
			if(step == 'step_2'){
				$(this).addClass("hidden");
				$('[data-step="step_3"]').removeClass('hidden');
			}
			if(step == 'step_3'){
				$(this).addClass("hidden");
			}
			$.post("calculate", json, function(data){
				$('.result[data-step="'+json.step+'"]').html(data);
			});
		});

		$('#clear').on('click', clear);
	});

	function get_array_from_textarea(textarea){
		var text = $(textarea).val().trim();
		var array = new Array();
		if(text.length != 0)
		 array = text.split('\n');

		return array;
	}

	function clear(){
		$('textarea').val('');
		$('.step-block input').val('');
		$('.step-block .result').html('');
		$('#file').val('');
		$('.step-block .btn').removeClass('hidden');
		$('.step-block[data-step="step_2"]').addClass('hidden');
		$('.step-block[data-step="step_3"]').addClass('hidden');
		$('.ta-label-count label').html('0');
	}
</script>