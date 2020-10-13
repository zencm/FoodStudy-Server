<?php



?>

@extends('voyager::master')

@section('page_header')
	<h1 class="page-title">
		<i class="voyager-book"></i>
		Question Catalog: {{ $study->name }}
	</h1>
@stop

@section('content')
	<div class="page-content container-fluid center-block">
		@include('voyager::alerts')

		<form name="catalogform" id="catalogform" method="post" action="/admin/foodapp/questioncatalog?id={{$study->id}}">
			@csrf


			<div class="row">
				<div class="col-sm-12 col-med-centered">

				</div>
			</div>

			<div class="row">
				<div class="col-sm-12 col-med-centered">


					<article class="fs-question-catalog" id="question-catalog">

						<div class="panel panel-bordered">

							<div class="alert alert-warning catalog-invalid-warning" role="alert" style="display: none;">Data is invalid - please check your input</div>


							<?php foreach( $catalog['groups'] as $gnum =>  $group ): ?>

							<div class="group-config">
								<div >
									<input type="checkbox" class="toggleswitch show-askafter" data-on="only ask after" data-off="always ask"
										   name="catalog[groups][{{$gnum}}][askafter-enabled]" {{isset($group['askafter-enabled']) ? 'checked' : ''}}
									/>
									<input type="time" class="askafter-time" value="{{ isset($group['askafter-time']) ? $group['askafter-time'] : ''}}" name="catalog[groups][{{$gnum}}][askafter-time]" />
								</div>
								<div >
									<input type="checkbox" class="toggleswitch show-reminder" data-on="remind user at" data-off="no reminder"
										   name="catalog[groups][{{$gnum}}][reminder-enabled]" {{isset($group['reminder-enabled']) ? 'checked' : ''}}
									/>
									<input type="time" class="reminder-time" value="{{ isset($group['reminder-time']) ? $group['reminder-time'] : ''}}" name="catalog[groups][{{$gnum}}][reminder-time]" />
								</div>
								<div >
									<label>ask for missed questions</label>
									<input type="checkbox" class="toggleswitch" data-on="yes" data-off="no" data-size="mini"
										   name="catalog[groups][{{$gnum}}][ask-missed]" {{isset($group['ask-missed']) ? 'checked' : ''}}
									/>
								</div>
							</div>

							<div class="table-responsive">
								<table id="dataTable" class="table table-hover" data-group="{{$gnum}}">
									<thead>
										<tr>
											<th style="width: 1px">Key</th>
											<th class="for-question">Question</th>
											<th style="width: 1px" class="for-type">Type</th>
											<th>Config</th>
											<th style="width: 1px"></th>
											<th style="width: 1px"></th>
										</tr>
									</thead>
									<tbody>
										@foreach ( $group['questions'] as $qnum => $question )
											<tr>
												<td>
													<input type="text" value="{{$question['key']}}" name="catalog[groups][{{$gnum}}][questions][{{$qnum}}][key]" />
												</td>
												<td>
													<input type="text" class="field-question" value="{{$question['question'] ?? ''}}" name="catalog[groups][{{$gnum}}][questions][{{$qnum}}][question]" placeholder="Do you…" />
												</td>
												<td class="for-type">
													<select name="catalog[groups][{{$gnum}}][questions][{{$qnum}}][type]">
														<option value="slider">Slider</option>
													</select>
												</td>
												<td>
													<div class="field-config slider">
														<div class="crow">
															<div>
																<label>Min</label>
																<input type="number" value="{{$question['config']['min']}}" name="catalog[groups][{{$gnum}}][questions][{{$qnum}}][config][min]" />
															</div>
															<div>
																<label>minLabel</label>
																<input type="text" value="{{$question['config']['minLabel']}}"
																	   name="catalog[groups][{{$gnum}}][questions][{{$qnum}}][config][minLabel]" />
															</div>
														</div>
														<div class="crow">
															<div>
																<label>max</label>
																<input type="number" value="{{$question['config']['max']}}" name="catalog[groups][{{$gnum}}][questions][{{$qnum}}][config][max]" />
															</div>
															<div>
																<label>maxLabel</label>
																<input type="text" value="{{$question['config']['maxLabel']}}"
																	   name="catalog[groups][{{$gnum}}][questions][{{$qnum}}][config][maxLabel]" />
															</div>
														</div>
													</div>
												</td>
												<td></td>
												<td>
													<a class="btn removequestion">
														<i class="voyager-trash"></i>
													</a>
												</td>
											</tr>
										@endforeach
									</tbody>
									<tfoot>
										<tr>
											<td colspan="2">
												<a class="btn btn-success addquestion">+ question</a>
											</td>
											<td colspan="3">
												<button type="submit" class="btn btn-secondary pull-right">save</button>
											</td>
										</tr>
									</tfoot>
								</table>
							</div>
							<?php endforeach; ?>

						</div>

						<div class="row">
							<div class="col-sm-12">
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12 col-md-6 ">

								<details>
									<summary>import/export</summary>

									<div class="exchange">
										<textarea class="data-exchange"></textarea>
									</div>
									<div class="tiny-instructions">
										<ol>
											<li>select all and copy</li>
											<li>go to other question catalog</li>
											<li>select all and paste</li>
											<li>click button</li>
										</ol>
									</div>
								</details>
							</div>
							<div class="col-sm-12 col-md-6 ">
								<a href="/admin/foodapp/studies" class="pull-right">cancel</a>

								<a class="btn btn-danger btn-importexchange">
									<i class="voyager-wand"></i>
									import data
									<small>(replaces existing data)</small>
								</a>
							</div>
						</div>

					</article>

				</div>
			</div>

		</form>

	</div>
@stop

@section('javascript')
	<script>
		$('document').ready(function(){
			$('.toggleswitch').bootstrapToggle();


			$('#question-catalog').each(() => {
				const form = $('#catalogform');
				const catalogEl = $(this);
				const tbody = catalogEl.find('tbody');
				const exchangeEl = catalogEl.find('.data-exchange');

				let qCount = tbody.children().length;


				exchangeEl.on('change', () => {
					catalogEl.find('.btn-importexchange').show();
				});
				catalogEl.find('.btn-importexchange').on('click', () => {
					importexchange(exchangeEl.val());
				});
				tbody.on('change', 'input,select', () => {
					validate();
				});
				tbody.on('keyup', 'input', () => {
					validate();
				});

				catalogEl.on('change', '.show-askafter',()=>{ refreshControls(); });
				catalogEl.on('change', '.show-reminder',()=>{ refreshControls(); });

				validate();
				refreshControls();


				function refreshControls(){
					catalogEl.find('.show-askafter').each((num, el)=>{
						const toggle = $(el);
						toggle .closest('.group-config')
							.find('.askafter-time')[toggle.prop('checked')?'show':'hide']();

					});
					catalogEl.find('.show-reminder').each((num, el)=>{
						const toggle = $(el);
						toggle .closest('.group-config')
							.find('.reminder-time')[toggle.prop('checked')?'show':'hide']();

					});

				}


				function importexchange( data ){

					let catalog;

					try{
						catalog = typeof data === 'string' ? JSON.parse(data) : data;

					}catch( e ){
					}

					if( !catalog?.groups ){
						alert('The data is invalid');
						return;
					}

					qCount = 0;

					tbody.empty();
					let gnum = -1;

					for( let group of catalog.groups ){
						gnum++;
						for( let question of group.questions ){

							addQuestion(question, gnum);
						}
					}
				}


				function validate(){

					let data;
					try{
						data = form.serializeJSON({useIntKeysAsArrayIndex: true});
					}catch( e ){
					}

					const valid = !!data?.catalog;

					catalogEl.find('.catalog-invalid-warning')[valid ? 'hide' : 'show']();

					exchangeEl.val(valid ? JSON.stringify(data.catalog) : 'invalid data');

					catalogEl.find('.btn-importexchange').hide();
				}


				function addQuestion( data, gnum = 0 ){
					const tr = $('<tr>').appendTo(tbody);
					const qnum = qCount++;

					data = data || {};


					$('<input type="text" />')
						.attr('name', `catalog[groups][${gnum}][questions][${qnum}][key]`)
						.attr('value', data.key || '')
						.appendTo($('<td>').appendTo(tr));

					$('<input type="text" class="field-question" />')
						.attr('name', `catalog[groups][${gnum}][questions][${qnum}][question]`)
						.attr('value', data.question || '')
						.attr('placeholder', 'Do you…')
						.appendTo($('<td>').appendTo(tr));

					$('<select>')
						.attr('name', `catalog[groups][${gnum}][questions][${qnum}][type]`)
						.append($('<option>').attr('value', 'slider').text('Slider'))
						.appendTo($('<td class="for-type">').appendTo(tr));


					let confEl = $('<div class="field-config slider">').appendTo($('<td>').appendTo(tr));


					let confRow = $('<div class="crow">').appendTo(confEl);
					$('<div>').appendTo(confRow)
						.append($('<label>').text('min'))
						.append($('<input type="number">')
							.attr('name', `catalog[groups][${gnum}][questions][${qnum}][config][min]`)
							.attr('value', data.config?.min || 1));

					$('<div>').appendTo(confRow)
						.append($('<label>').text('minLabel'))
						.append($('<input type="text">')
							.attr('name', `catalog[groups][${gnum}][questions][${qnum}][config][minLabel]`)
							.attr('value', data.config?.minLabel || 'least'));


					confRow = $('<div class="crow">').appendTo(confEl);
					$('<div>').appendTo(confRow)
						.append($('<label>').text('max'))
						.append($('<input type="number">')
							.attr('name', `catalog[groups][${gnum}][questions][${qnum}][config][max]`)
							.attr('value', data.config?.max || 10));

					$('<div>').appendTo(confRow)
						.append($('<label>').text('maxLabel'))
						.append($('<input type="text">')
							.attr('name', `catalog[groups][${gnum}][questions][${qnum}][config][maxLabel]`)
							.attr('value', data.config?.maxLabel || 'most'));



					$('<td>').appendTo(tr);

					$('<a class="btn removequestion" ><i class="voyager-trash"></i></a>')
						.appendTo($('<td>').appendTo(tr));



					validate();
				}


				catalogEl.on('click', '.removequestion', ( event ) => {
					if( confirm('delete question?') ) $(event.currentTarget).closest('tr').remove();
					validate();
				});

				catalogEl.on('click', '.addquestion', () => {
					addQuestion({
						key: 'question.num_' + (qCount + 1), type: 'slider', config: {
							min: 1, max: 5, minLabel: 'niemals', maxLabel: 'immer'
						}
					});
				});



			});


		});
	</script>
@stop
