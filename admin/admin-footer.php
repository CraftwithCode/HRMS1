		</div>
		<?php if(isset($_SESSION['username'])){ include('../chat/index.php'); } ?>
			<!-- jQuery 3 -->
			<!-- <script src="../assets/bower_components/jquery/dist/jquery.min.js"></script> -->
			<!-- Bootstrap 3.3.7 -->
			<!-- <script src="../assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script> -->
			<!-- FastClick -->
			<script src="../assets/bower_components/fastclick/lib/fastclick.js"></script>
			<!-- AdminLTE App -->
			<script src="../assets/dist/js/adminlte.min.js"></script>
			<script src="../assets/bower_components/moment/min/moment.min.js"></script>
			<script src="../assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
			
			<!-- Sparkline -->
			<!-- <script src="../assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script> -->
			<!-- jvectormap  -->
			<!-- <script src="../assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script> -->
			<!-- <script src="../assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script> -->
			<script src="../AdminLTE/plugins/timepicker/bootstrap-timepicker.min.js"></script>
			<!-- SlimScroll -->
			<script src="../assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
			<script src="../assets/bower_components/ckeditor/ckeditor.js"></script>
			<!-- ChartJS -->
			<!-- <script src="../assets/bower_components/chart.js/Chart.js"></script> -->
			<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
			<script src="../assets/dist/js/pages/dashboard2.js"></script>
						
			<!-- AdminLTE for demo purposes -->
			<script src="../assets/dist/js/demo.js"></script>
			<script src="../assets/js/custom.js"></script>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					var FromEndDate = new Date();
					var StartDate = new Date();
					
					FromEndDate.setFullYear(FromEndDate.getFullYear() - 20);
					FromEndDate.setDate(30);
					FromEndDate.setMonth(11);

					StartDate.setFullYear(StartDate.getFullYear() - 70);
					StartDate.setDate(1);
					StartDate.setMonth(0);

					jQuery('.datepicker-dob').datepicker({
						startDate: StartDate,
						startView: "year",
						endDate: FromEndDate, 
						autoclose: true,
					});

					jQuery('.rangepicker').daterangepicker();
					$('.timepicker').timepicker({
				    	showInputs: false
				    })

					jQuery('.ar-table').DataTable({
						'paging'      : true,
						'lengthChange': true,
						'searching'   : true,
						'ordering'    : true,
						'info'        : true,
						'autoWidth'   : true
					});

					// console.log(jQuery('#editor1').length);
					if(jQuery('#editor1').length){
						var editor = CKEDITOR.replace('editor1');
						if(editor!=undefined){
							editor.on( 'change', function( evt ) {
								
							    // getData() returns CKEditor's HTML content.
							    // jQuery('textarea[name="links"]').val(evt.editor.getData());
							    jQuery('textarea[name="links"]').val(CKEDITOR.instances.editor1.getData());
							    console.log( 'Total bytes: ' + evt.editor.getData().length );
							});
						}
					}

					jQuery('.open-lms').click(function(e){
						e.preventDefault();
						jQuery('#search-btn').trigger('click');
					});
					
                    ////FOR CHATBOT/////////////
					jQuery('.open-chatbot').click(function(e){
						e.preventDefault();
						jQuery('#search-btn1').trigger('click');
					});
                    ///////////////////////////////
										
					//////FOR PM///////////////////
					jQuery('.open-pm').click(function(e){
						e.preventDefault();
						
						jQuery('#search-btn2').trigger('click');
					});
                    ///////////////////////////////
					
					jQuery('input[name="pic"]').change(function(){
						readURL(this);
					});
					
					jQuery('.ar-company').change(function(){
						company = jQuery(this).val();
						jQuery('.ar-employee').prop('disabled',true);
						getEmployee(company, 'addadmin');
					});

					jQuery('.sel-company').change(function(){
						company = jQuery(this).val();
						jQuery('.ar-employee').prop('disabled',true);
						if(company != 'all'){
							getEmployee(company, 'company');
							getData(company, 'group');
							getData(company, 'ethnic');
						} else{
							jQuery('.ar-employee').prop('multiple', false);
						}
					});

					jQuery('.emp_step_1 select[name="company"]').change(function(){
						$this = jQuery(this);
						val = jQuery(this).val();
						jQuery.ajax({
							url: '/hrms/includes/ajaxfunctions.php?action=get&type=companycount&company='+val,
							success: function(res){
								console.log(res);
								if(res=='true'){
									alert('OUT OF LIMIT, extend limit for this company.');
									$this.val('');
									$this.focus();
								}
							},
							error: function(err){
								console.log(err);
							}
						});
					});

					jQuery('.filter').submit(function(e){
						e.preventDefault();
						emp = jQuery('.ar-employee').val();
						yr = jQuery('.year').val();
						mon = jQuery('.month').val();
						range = jQuery('.daterange').val();
						url = '/hrms/admin/viewtimesheet.php?employee='+emp+'&year='+yr+'&month='+mon+'&daterange='+range;
						jQuery('.timesheet-iframe').attr('src',url);
					});

					jQuery('.filter-punches select').change(function(){
						jQuery('.filter-punches').submit();
					});

					jQuery('.filter-punches').submit(function(e){
						e.preventDefault();
						
						$file = 'viewpunches.php';
						if(jQuery(this).hasClass('ar-exceptions')){
							$file = 'viewexceptions.php';
						}

						emp = jQuery('.ar-employee').val();
						yr = jQuery('.year').val();
						mon = jQuery('.month').val();
						range = jQuery('.daterange').val();

						url = '/hrms/admin/'+$file+'?employee='+emp+'&year='+yr+'&month='+mon+'&daterange='+range;
						if(jQuery('.sel-company').length>0 && jQuery('.sel-company').length!=undefined){
							company = jQuery('.sel-company').val();
							url = '/hrms/admin/'+$file+'?company='+company+'&employee='+emp+'&year='+yr+'&month='+mon+'&daterange='+range;
						}
						jQuery('.view-iframe').attr('src',url);
					});

					setTimeout(function(){
						if(jQuery('#update-punches .sel-company').length>0){
							jQuery('.sel-company').trigger('change');
							setTimeout(function(){
								jQuery('.ar-employee').val('<?=$punch['emp_id']?>');
								jQuery('.ar-employee').trigger('change');
							},1200);
						}
					},500);

					jQuery('.filter-accrual').submit(function(e){
						e.preventDefault();
						emp = jQuery('.ar-employee').val();
						url = '/hrms/admin/accrual-listview.php?employee='+emp;
						jQuery('.view-iframe').attr('src',url);
					});
                    
                    
                    jQuery('.filter-accrualbal select').change(function(){
						jQuery('.filter-accrualbal').submit();
					});
					jQuery('.filter-accrualbal').submit(function(e){
						e.preventDefault();
						emp = jQuery('.ar-employee').val();
						url = '/hrms/admin/accrualbal-listview.php?employee='+emp;
						if(jQuery('.sel-company').length){
						    $co = jQuery('.sel-company').val();
						    url = '/hrms/admin/accrualbal-listview.php?company='+$co+'&employee='+emp;  
						}
						
						jQuery('.view-iframe').attr('src',url);
					});
					
					jQuery('.filter-accrualreq select').change(function(){
						jQuery('.filter-accrualreq').submit();
					});
					jQuery('.filter-accrualreq').submit(function(e){
						e.preventDefault();
						emp = jQuery('.ar-employee').val();
						url = '/hrms/admin/viewaccrual-request.php?employee='+emp;
						if(jQuery('.sel-company').length){
						    $co = jQuery('.sel-company').val();
						    url = '/hrms/admin/viewaccrual-request.php?company='+$co+'&employee='+emp;  
						}
						
						jQuery('.view-iframe').attr('src',url);
					});

					jQuery('.filter-schedule').submit(function(e){
						e.preventDefault();
						emp = jQuery('.ar-employee').val();
						url = '/hrms/admin/schedule-listview.php?employee='+emp;
						jQuery('.view-iframe').attr('src',url);
					});

					jQuery('.ar-forms').submit(function(e){
						e.preventDefault();
						var $this = jQuery(this);
						var formData = new FormData(this);
						if(getUrlParameter('edit')!='' && getUrlParameter('edit')!=undefined){
							edit = getUrlParameter('edit');
							url = '/hrms/includes/ajaxfunctions.php?edit='+edit+'&action=update';
						} else {
							url = '/hrms/includes/ajaxfunctions.php';
						}
						jQuery.ajax({
					        url: url,
					        type: 'POST',
					        data: formData,
					        cache: false,
					        contentType: false,
					        processData: false,
					        dataType: 'JSON',
					        success: function(res){
								console.log(res);
								alert(res.msg);
								if(res.result == 'success'){
									location.reload();
								} else {
									$this.find('input[type="submit"]').prop('disabled',false);
								}								
								if(getUrlParameter('edit')!='' && getUrlParameter('edit')!=undefined){
									location.reload();
								}
							},
							error: function(err){
								$this.find('input[type="submit"]').prop('disabled',false);
								console.log(err);
							}
					    });
					});

					jQuery('.hire-steps').submit(function(e){
						e.preventDefault();
						var $this = jQuery(this);
						var formData = new FormData(this);
						url = '/hrms/includes/ajaxfunctions.php?type=hire-defaults';
						
						jQuery.ajax({
					        url: url,
					        type: 'POST',
					        data: formData,
					        cache: false,
					        contentType: false,
					        processData: false,
					        dataType: 'JSON',
					        success: function(res){
								console.log(res);
								alert(res.msg);
								if(res.result == 'success'){
									location.reload();
								} else {
									$this.find('input[type="submit"]').prop('disabled',false);
								}								
								if(getUrlParameter('edit')!='' && getUrlParameter('edit')!=undefined){
									location.reload();
								}
							},
							error: function(err){
								$this.find('input[type="submit"]').prop('disabled',false);
								console.log(err);
							}
					    });
					});

					jQuery('.time-steps').submit(function(e){
						e.preventDefault();
						var $this = jQuery(this);
						var formData = new FormData(this);
						url = '/hrms/includes/ajaxfunctions.php?type=timeentry';
						if(getUrlParameter('id')!='' && getUrlParameter('id')!=undefined){
							url = '/hrms/includes/ajaxfunctions.php?type=timeentry&edit='+getUrlParameter('id');
						}
						
						jQuery.ajax({
					        url: url,
					        type: 'POST',
					        data: formData,
					        cache: false,
					        contentType: false,
					        processData: false,
					        dataType: 'JSON',
					        success: function(res){
								console.log(res);
								alert(res.msg);
								if(res.result == 'success'){
									location.reload();
								} else {
									$this.find('input[type="submit"]').prop('disabled',false);
								}								
								// if(getUrlParameter('edit')!='' && getUrlParameter('edit')!=undefined){
								// 	location.reload();
								// }
							},
							error: function(err){
								$this.find('input[type="submit"]').prop('disabled',false);
								console.log(err);
							}
					    });
					});

					jQuery('.benefit-steps').submit(function(e){
						e.preventDefault();
						if(jQuery('#editor1').length){
							
						    jQuery('textarea[name="links"]').val(CKEDITOR.instances.editor1.getData());
						    // console.log( 'Total bytes: ' + evt.editor.getData().length );
							
						}
						var $this = jQuery(this);
						var formData = new FormData(this);
						url = '/hrms/includes/ajaxfunctions.php?type=benefits';
						if(getUrlParameter('edit')!='' && getUrlParameter('edit')!=undefined){
							edit = getUrlParameter('edit');
							url = '/hrms/includes/ajaxfunctions.php?type=benefits&edit='+edit;
						}
						
						jQuery.ajax({
					        url: url,
					        type: 'POST',
					        data: formData,
					        cache: false,
					        contentType: false,
					        processData: false,
					        dataType: 'JSON',
					        success: function(res){
								console.log(res);
								alert(res.msg);
								if(res.result == 'success'){
									location.reload();
								} else {
									$this.find('input[type="submit"]').prop('disabled',false);
								}								
								// if(getUrlParameter('edit')!='' && getUrlParameter('edit')!=undefined){
								// 	location.reload();
								// }
							},
							error: function(err){
								$this.find('input[type="submit"]').prop('disabled',false);
								console.log(err);
							}
					    });
					});

					jQuery('.emp-steps').submit(function(e){
						e.preventDefault();
						var $this = jQuery(this);
						$this.find('input[type="submit"]').prop('disabled',true);
						var formData = new FormData(this);
						if(getUrlParameter('id')!='' && getUrlParameter('id')!=undefined){
							emp = getUrlParameter('id');
							url = '/hrms/includes/ajaxfunctions.php?emp='+emp+'&action=update';
							if(getUrlParameter('edit')!='' && getUrlParameter('edit')!=undefined){
								edit = getUrlParameter('edit');
								url = '/hrms/includes/ajaxfunctions.php?emp='+emp+'&edit='+edit+'&action=update';
							}
						} else if(jQuery('#ar-common-contact').length){
							url = '/hrms/includes/ajaxfunctions.php?common=true&action=update';
							if(getUrlParameter('edit')!='' && getUrlParameter('edit')!=undefined){
								edit = getUrlParameter('edit');
								url = '/hrms/includes/ajaxfunctions.php?common=true&edit='+edit+'&action=update';
							}
						}else if(!$this.hasClass('emp_step_1')){
							// if(emp!='' && emp != undefined){
							// 	url = '/hrms/includes/ajaxfunctions.php?emp='+emp;
							// } else {
								$this.find('input[type="submit"]').prop('disabled',false);
								alert('Save Employee data first');
							// }
						} else{
							url = '/hrms/includes/ajaxfunctions.php' ;
						}
						// alert(url);
						if(url.length){
						    jQuery.ajax({
						        url: url,
						        type: 'POST',
						        data: formData,
						        cache: false,
						        contentType: false,
						        processData: false,
						        dataType: 'JSON',
						        success: function(res){
									console.log(res);
									if(res.result == 'success'){
										if($this.hasClass('emp_step_1') && (getUrlParameter('id')=='' || getUrlParameter('id')==undefined)){
											// $this.append('<input type="hidden" name="employeeid" value="'+res.empid+'">');
											window.location.href = '/hrms/admin/update-employee.php?id='+res.empid;
										}
									} else {
										$this.find('input[type="submit"]').prop('disabled',false);
									}
									alert(res.msg);
									if(getUrlParameter('edit')!='' && getUrlParameter('edit')!=undefined){
										location.reload();
									}
								},
								error: function(err){
									$this.find('input[type="submit"]').prop('disabled',false);
									console.log(err);
								}
						    });
						}
					});

					jQuery('.ar-del').click(function(e){
						e.preventDefault();
						type = jQuery(this).data('type');
						id = jQuery(this).data('id');
						if(confirm('Are you sure to delete ?')){
							jQuery.ajax({
								url: '/hrms/includes/ajaxfunctions.php?action=del&id='+id+'&type='+type,
								success: function(res){
									console.log(res);
									if(res=='true'){
										location.reload();
									}
								},
								error: function(err){
									console.log(err);
								}
							});
						}
					});

					jQuery('.import-ethnic').click(function(e){
						e.preventDefault();
						id = jQuery(this).data('id');
						jQuery.ajax({
							url: '/hrms/includes/ajaxfunctions.php?id='+id+'&type=import-default-ethnic',
							dataType: 'JSON',
							success: function(res){
								console.log(res);
								if(res.result=='success'){
									location.reload();
								}
							},
							error: function(err){
								console.log(err);
							}
						});
					});
				});

				function getEmployee($gid, $type){
					company = $gid;
					type = $type;
					jQuery.ajax({
						url: '/hrms/includes/ajaxfunctions.php?action=get&type='+type+'&company='+company,
						success: function(res){
							console.log(res);
							jQuery('.ar-employee').html(res);
							if($type=='company' && jQuery('.ar-employee').hasClass('ar-announcement')){
								jQuery('.ar-employee option[value=""]').html('All');
								jQuery('.ar-employee option[value=""]').val('all');
								jQuery('.ar-employee').prop('multiple', true);
							}
							jQuery('.ar-employee').prop('disabled',false);
						},
						error: function(err){
							console.log(err);
						}
					});
				}

				function getData(company, type){

					jQuery.ajax({
						url: '/hrms/includes/ajaxfunctions.php?action=get&type='+type+'&company='+company,
						success: function(res){
							console.log(res);
							if(type == 'group')
								jQuery('.ar-group').html(res);
							if(type == 'ethnic')
								jQuery('.ar-ethnic').html(res);
						},
						error: function(err){
							console.log(err);
						}
					});
				}

				function getUrlParameter(sParam) {
				    var sPageURL = window.location.search.substring(1),
				        sURLVariables = sPageURL.split('&'),
				        sParameterName,
				        i;

				    for (i = 0; i < sURLVariables.length; i++) {
				        sParameterName = sURLVariables[i].split('=');

				        if (sParameterName[0] === sParam) {
				            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
				        }
				    }
				}

				function readURL(input) {
					if (input.files && input.files[0]) {
						var reader = new FileReader();

						reader.onload = function(e) {
							jQuery('#display-img').attr('src', e.target.result);
							jQuery('#display-img').css('display','block');
						}

						reader.readAsDataURL(input.files[0]);
					}
				}

				function getDateRange(){
					year = jQuery('.year').val();
					month = jQuery('.month').val();
					jQuery.ajax({
						url: '/hrms/includes/ajaxfunctions.php?action=get&type=daterange&year='+year+'&month='+month,
						success: function(res){
							console.log(res);
							jQuery('.daterange').html(res);
						},
						error: function(err){
							console.log(err);
						}
					});
				}

				function getTimeDiff(start,end){
					$starttime = new Date("1970-1-1 " + start);
					$endtime = new Date("1970-1-1 " + end);
					if($endtime < $starttime){
						$endtime = new Date("1970-1-2 " + end);
					}
					dif = $endtime - $starttime;
					seconds = dif/1000;
					minutes = parseInt(seconds/60, 10);
					hours = parseInt(minutes/60, 10);
					seconds %= 60;
					minutes %= 60;
					// console.log('Seconds: '+seconds);
					// console.log('Minutes: '+minutes);
					// console.log(hours+'.'+minutes);
					diff = hours+'.'+minutes;
					return diff;
				}
				
				function updateActualShift(){
					total = jQuery('input[name="total"]').val();
					total = total.split('.');
					totalmin = parseInt(total[0]*60) + parseInt(total[1]);
					
					lunchtotal = jQuery('input[name="lunchtotal"]').val();
					lunchtotal = lunchtotal.split('.');
					lunchmin = parseInt(lunchtotal[0]*60) + parseInt(lunchtotal[1]);
					
					minutes = totalmin - lunchmin;
					hours = parseInt(minutes/60, 10);
					minutes %= 60;
					
					jQuery('input[name="shifttotal"]').val(hours+'.'+minutes);
				}

			</script>
			
	</body>
</html>