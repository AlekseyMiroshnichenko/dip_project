<link type="text/css" href="<?=base_url();?>app/vendors/jquery_ui/jquery-ui.min.css" rel="stylesheet" />
<script type="text/javascript" src="<?=base_url();?>app/vendors/jquery_ui/jquery-ui.js"></script>
<script type="text/javascript" src="<?=base_url();?>app/vendors/jquery_ui/datepicker-settings.js"></script>

<div class="row">
	<div class="col-md-8 col-sm-12">
		<div class="row">
			<div class="col-md-9">
				<h4>Cпівробітники</h4>
			</div>
			<div class="col-md-3">
				<span id="add-user" class="float-right" title="Додати співробітника">
					Додати
					<i class="fa fa-plus" aria-hidden="true"></i>
				</span>
			</div>
		</div>
		<div class="wrap-table">
			<table id='users' class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Прізвище</th>
						<th>Ім'я</th>
						<th>Логін</th>
						<th class="text-center">Пароль</th>
						<th class="text-center">Роль</th>
						<th class="text-center th-actions">Дії</th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-md-4 col-sm-12">
		<div class="row">
			<div class="col-md-6">
				<h4>Історія входів</h4>
			</div>
			<div class="col-md-6">
				<div class='input-group date'>
					<input type="text" id="datepicker" class="form-control" value="<?=date("Y-m-d");?>" />
					<span class="input-group-addon">
	                    <i class="fa fa-calendar" aria-hidden="true"></i>
	                </span>
				</div>
			</div>
			<script type="text/javascript">
		       
	    	</script>
		</div>
		<div class="wrap-table">
			<table id='users_log'  class="table table-striped">
				<thead>
					<tr>
						<th>Прізвище</th>
						<th>Ім'я</th>
						<th class="text-center">ip</th>
						<th class="text-center th-datetime">Дата входу</th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function(){

		get_users();

		$("#datepicker").on('change',function(){
			var date = $(this).val();
			get_users_log(date);
		});
		$("#datepicker").trigger('change');
		
		$(".date span").on('click',function(){
			$("#datepicker").datepicker("show");
		});

		$(".body").on("mouseover","td[data-param='show_pass']",function(){
			var password = $(this).data('password');
			$(this).text(password);
		});

		$(".body").on("mouseout","td[data-param='show_pass']",function(){
			$(this).text(" ***** ");
		});

		$("#add-user").on('click', function(){
			$("#modal-user").attr("data-modal-type","add");
			$("#modal-title").text("Додати користувача");
			$("#modal-user").modal("show");
		});

		$(".body").on("click",".edit",function(){
			var row = $(this).closest('tr');

			$("#modal-user").attr("data-user-id",row.data("user-id"));
			$("#modal-user").attr("data-modal-type","edit");
			$("#modal-title").text("Редагувати користувача");

			$("#modal-user input[name='surname']").val(row.find('[data-param="surname"]').text());
			$("#modal-user input[name='name']").val(row.find('[data-param="name"]').text());
			$("#modal-user input[name='email']").val(row.find('[data-param="email"]').text());
			$("#modal-user input[name='password']").val(row.find('[data-password]').data('password'));
			$("#modal-user select[name='user-role']").val(row.find('[data-role]').data('role'));

			$("#modal-user").modal("show");
		});

		$("#modal-user").on('hidden.bs.modal', function(){
			$("#modal-user input").val("");
			clear_danger("email");
			clear_danger("password");
			$("#modal-user select[name='user-role']").val('1');
		});

		$("#modal-user input").on('change',function(){
			$(this).val($(this).val().trim());
		})

		$("#modal-user input[name='email']").on('change',function(){
			var user_id = $("#modal-user").data('user-id');
			var old_email = $("tr[data-user-id='"+user_id+"']").find('[data-param="email"]').text();
			if($(this).val() != old_email)
				is_email_exist();
			else
				clear_danger('email');
		});

		$("#modal-user input[name='password']").on('change',function(){
			if($(this).val().length < 6)
				set_danger('password');
			else
				clear_danger('password');
		});

		$("#saveBtn").on('click',function(event){
			if($("#modal-user input").hasClass("is-invalid")){
				return;
			}

			var user_info = get_user_info_modal();

			if($("#modal-user").data('modal-type') == "edit"){
				$.post("/users/edit_user", user_info, function(){
					get_users();
				});
			}

			if($("#modal-user").data('modal-type') == "add"){
				$.post("/users/add_user", user_info, function(){
					get_users();
				});
			}

			$("#modal-user").modal('hide');
		});

		$("body").on("click",".block", function(){
			var user_id = $(this).closest('tr').data('user-id');
			$.post("/users/block_user", {id:user_id}, function(){
				get_users();
			});
		});

		$("body").on("click",".unblock", function(){
			var user_id = $(this).closest('tr').data('user-id');
			$.post("/users/unblock_user", {id:user_id}, function(){
				get_users();
			});
		});

	});

	function get_users(){
		$.getJSON("/users/get_users",function(data){
			var tbody_content = "";
			data.forEach(function(row, i, data){
				tbody_content += "<tr data-user-id='"+row.id+"' "+(row.status == 0?"class='half-opacity'":"")+">"
									+"<td>"+(i+1)+"</td>"
									+"<td data-param='surname'>"+row.surname+"</td>"
									+"<td data-param='name'>"+row.name+"</td>"
									+"<td data-param='email'>"+row.email+"</td>"
									+"<td class='text-center' data-param='show_pass' data-password="+row.password+"> ***** </td>"
									+"<td class='text-center' data-param='role' data-role="+row.role+">"+row.role_name+"</td>"
									+ "<td class='text-center td-actions'>"
										+"<a class='btn btn-default btn-sm float-left' title='Увійти під користувачем' href='<?=base_url();?>/users/go_login_to_user/"+row.id+"'><i class='fa fa-male'></i></a>"
			                            +"<a class='btn btn-default btn-sm edit float-left' title='Редагувати користувача'><i class='fa fa-edit'></i></a>"
			                            +(row.role != 1
			                            	?(row.status == 1
				                            	?"<a class='btn btn-warning btn-sm block float-left' title='Заблокувати користувача'><i class='fa fa-unlock-alt'></i></a>"
				                            	:"<a class='btn btn-danger btn-sm unblock float-left' title='Розблокувати користувача'><i class='fa fa-unlock'></i></a>"
				                            ):""
				                        )
		                            +"</td>"
								+"</tr>";
			});
			$("#users>tbody").html(tbody_content);
		});
	}

	function get_users_log(date){
		$.getJSON("/users/get_users_log",{date:date},function(data){
			var tbody_content = "";
			if(data.length > 0){
				data.forEach(function(row, i, data){
					tbody_content += "<tr>"
										+"<td>"+row.surname+"</td>"
										+"<td>"+row.name+"</td>"
										+"<td class='text-center'>"+row.user_ip+"</td>"
										+"<td class='text-center'>"+row.date_time+"</td>"
									+"</tr>";
				});
			}else{
				tbody_content += "<tr>"
									+"<td colspan='100%' class='text-center'>Данних немає</td>"
								+"</tr>";
			}
			
			$("#users_log>tbody").html(tbody_content);
		});
	}

	function is_email_exist(){
		var email = $("#modal-user input[name='email']").val();
		$.post("/users/is_email_exist",{email:email},function(data){
			if(data == "false"){
				clear_danger('email');
			}else{
				set_danger('email');
			}
		});
	}

	function clear_danger(param){
		$("#modal-user input[name='"+param+"']").removeClass("is-invalid");
		$("#"+param+"Danger").addClass("hidden");
	}

	function set_danger(param){
		$("#modal-user input[name='"+param+"']").addClass("is-invalid");
		$("#"+param+"Danger").removeClass("hidden");
	}

	function get_user_info_modal(){
		json = {};
		json.id = $("#modal-user").data('user-id');
		json.surname = $("#modal-user input[name='surname']").val();
		json.name =$("#modal-user input[name='name']").val();
		json.email =$("#modal-user input[name='email']").val();
		json.password =$("#modal-user input[name='password']").val();
		json.role =$("#modal-user select[name='user-role']").val();
		return json;
	}


</script>

<div class="modal fade" id="modal-user" data-user-id="" data-modal-type="" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
        	<thead class="">
        		<tr>
        			<th>Параметр</th>
        			<th>Значення</th>
        		</tr>
        	</thead>
        	<tbody>
        		<tr>
        			<td>Прізвище</td>
        			<td><input type="text" name="surname" class="form-control"></td>
        		</tr>
        		<tr>
        			<td>Ім'я</td>
        			<td><input type="text" name="name" class="form-control"></td>
        		</tr>
        		<tr>
        			<td>Логін</td>
        			<td>
    					<input type="email" name="email" class="form-control">
    					<small id="emailDanger" class="text-danger hidden">
			            	Користувач з таким email вже існує
			            </small> 
        			</td>
        		</tr>
        		<tr>
        			<td>Пароль</td>
        			<td>
        				<input type="text" name="password" class="form-control">
						<small id="passwordDanger" class="text-danger hidden">
				            Пароль повинен містити не менше 6 символів
				        </small> 
        			</td>
        		</tr>
        		<tr>
        			<td>Роль</td>
        			<td>
	        			<select name="user-role" id="user-role" class="form-control">
	        			<?php foreach ($roles as $role) {
	        				echo "<option value=$role->id>$role->role_name</option>";
	        			}?>
	        			</select>
        			</td>
        		</tr>
        	</tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="saveBtn">Зберегти</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
      </div>
    </div>
  </div>
</div>