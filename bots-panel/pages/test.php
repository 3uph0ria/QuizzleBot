<?php
include_once '../include/header/header.php';
?>
<!-- Navbar -->
<? include_once '../include/navbar/navbar.php' ?>

<!-- Main Sidebar Container -->
<? include_once '../include/main-sidebar/main-sidebar.php' ?>

<?php
$test = $Database->GetTest($_GET['IdTest']);
?>

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0">Редактирование теста: <?=$test['Name']?></h1>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>
                <!-- /.content-header -->

                <!-- Main content -->
        <div class="content">
          <div class="container-fluid">
            <div class="shadow">
                <div class="container p-4">
                <? if($_SESSION['alert']): ?>
                    <div class="alert border-left-warning alert-dismissible fade show mt-3" role="alert" style="border-left: .25rem solid #1ef600!important;">
												<?=$_SESSION['alert']?>
												<button type="button" class="close" data-dismiss="alert" aria-label="Close">
														<span aria-hidden="true">&times;</span>
												</button>
										</div>
                        <? unset($_SESSION['alert']); ?>
                    </div>
                <? endif; ?>

								<div class="container">
                	<a href="#addQuestion" class="btn btn-success my-2" data-toggle="modal">Добавить вопрос</a>
								</div>

                <div class="modal fade" id="addQuestion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Добавить вопрос</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                            </div>
                            <div class="modal-body">
                                <form action="actions/action_question.php?method=add" method="post">
                                    <div class="md-form mt-4" style="display: none">
                                        <label for="button_text">id</label>
                                        <input type="text" id="IdTest" class="form-control" name="IdTest" value="<?=$_GET['IdTest']?>" maxlength="20">
                                    </div>
                                    <div class="md-form mt-4">
                                        <label for="button_text">Кол-во баллов</label>
                                        <input type="number" min="0" id="Score"  class="form-control" name="Score" maxlength="20">
                                    </div>
																		<div class="md-form mt-4">
                                        <label for="Img">Изображение (если нету оставьте пустым)</label>
                                        <input type="text" min="0" id="Img"  class="form-control" name="Img" maxlength="200">
                                    </div>
                                    <div class="md-form mt-4">
                                        <label for="value">Текст вопроса</label>
                                        <textarea name="Text" id="Text" cols="30" rows="2" class="form-control w-100" maxlength="500"></textarea>
                                    </div>
                                    <div class="text-center mt-4 d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary btn-block btn-rounded z-depth-1a" style="width: 40%;height: 50px;border-radius: 34px">Добавить</button>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>

								<?
									$questions = $Database->GetQuestions($_GET['IdTest']);
									if($questions):
									for($i = 0; $i < Count($questions); $i++):
								?>
									<div class="mt-5 mb-3 d-block container">
										<table class="table table-striped">
											<thead>
													<tr>
															<th scope="col">Вопрос</th>
															<th scope="col">Кол-во баллов</th>
															<th scope="col">Изменить</th>
															<th scope="col">Удалить</th>
													</tr>
											</thead>
											<tbody>
													<tr>
															<td class="col-lg-4"><?=base64_decode($questions[$i]['Text'])?></td>
															<td class="col-lg-2"><?=$questions[$i]['Score']?></td>
															<td class="col-lg-3"><a href="#updQuestion<?=$i?>" class="btn btn-primary" data-toggle="modal">Изменить</a></td>
															<td class="col-lg-3"><a href="#delQuestion<?=$i?>" class="btn btn-danger" data-toggle="modal">Удалить</a></td>
													</tr>
											</tbody>
										</table>

										<div class="modal fade" id="updQuestion<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
											<div class="modal-dialog modal-lg" role="document">
													<div class="modal-content">
															<div class="modal-header">
																		<h5 class="modal-title" id="exampleModalLabel">Редактирование вопроса</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
															</div>
															<div class="modal-body">
																	<form action="actions/action_question.php?method=upd" method="post">
																			<div class="md-form mt-4" style="display: none">
																					<label for="Id">id</label>
																					<input type="text" id="Id" class="form-control" name="Id" value="<?=$questions[$i]['Id']?>" maxlength="20">
																			</div>
																			<div class="md-form mt-4">
																					<label for="button_text">Кол-во баллов</label>
																					<input type="number" min="0" id="Score" value="<?=$questions[$i]['Score']?>" class="form-control" name="Score" maxlength="20">
																			</div>
																			<div class="md-form mt-4">
																					<label for="Img">Изображение (если нету оставьте пустым)</label>
																					<input type="text" min="0" id="Img" value="<?=$questions[$i]['Img']?>" class="form-control" name="Img" maxlength="200">
																			</div>
																			<div class="md-form mt-4">
																					<label for="value">Текст вопроса</label>
																					<textarea name="Text" id="Text" cols="30" rows="3" class="form-control w-100" maxlength="500"><?=base64_decode($questions[$i]['Text'])?></textarea>
																			</div>
																			<div class="text-center mt-4 d-flex justify-content-center">
																					<button type="submit" class="btn btn-primary btn-block btn-rounded z-depth-1a" style="width: 40%;height: 50px;border-radius: 34px">Сохранить</button>
																			</div>
																	</form>
															</div>
															<div class="modal-footer">
																	<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
															</div>
													</div>
											</div>
                		</div>
										<div class="modal fade" id="delQuestion<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
											<div class="modal-dialog modal-lg" role="document">
													<div class="modal-content">
															<div class="modal-header">
																		<h5 class="modal-title" id="exampleModalLabel">Удаление вопроса</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
															</div>
															<div class="modal-body">
																	<form action="actions/action_question.php?method=del" method="post">
																			<div class="md-form mt-4" style="display: none">
																					<label for="Id">id</label>
																					<input type="text" id="Id" class="form-control" name="Id" value="<?=$questions[$i]['Id']?>" maxlength="20">
																			</div>
																			<h3 class="text-center">Вы действительно хотите удалить вопрос "<?=base64_decode($questions[$i]['Text'])?>"?</h3>
																			<div class="text-center mt-4 d-flex justify-content-center">
																					<button type="submit" class="btn btn-danger btn-block btn-rounded z-depth-1a" style="width: 40%;height: 50px;border-radius: 34px">Удалить</button>
																			</div>
																	</form>
															</div>
															<div class="modal-footer">
																	<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
															</div>
													</div>
											</div>
							</div>

										<div class="container mb-2">
											<a href="#addAnswer<?=$i?>" class="btn btn-success my-2 w-100" data-toggle="modal">Добавить ответ</a>
										</div>

										<div class="modal fade" id="addAnswer<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
											<div class="modal-dialog modal-lg" role="document">
													<div class="modal-content">
															<div class="modal-header">
																		<h5 class="modal-title" id="exampleModalLabel">Добавить ответ</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
															</div>
															<div class="modal-body">
																	<form action="actions/action_answer.php?method=add" method="post">
																			<div class="md-form mt-4" style="display: none">
																					<label for="button_text">id</label>
																					<input type="text" id="IdQuestion" class="form-control" name="IdQuestion" value="<?=$questions[$i]['Id']?>" maxlength="20">
																			</div>
																			<div class="md-form mt-4">
																					<label for="Correct">Правильный?</label>
																					<select class="browser-default custom-select" name="Correct">
																							<option>Да</option>
																							<option selected>Нет</option>
																					</select>
																			</div>
																			<div class="md-form mt-4">
																					<label for="value">Текст ответа</label>
																					<textarea name="Text" id="Text" cols="30" rows="3" class="form-control w-100" maxlength="500"></textarea>
																			</div>
																			<div class="text-center mt-4 d-flex justify-content-center">
																					<button type="submit" class="btn btn-primary btn-block btn-rounded z-depth-1a" style="width: 40%;height: 50px;border-radius: 34px">Добавить</button>
																			</div>
																	</form>
															</div>
															<div class="modal-footer">
																			<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
															</div>
													</div>
											</div>
                		</div>
										<?
												$answers = $Database->GetAnswers($questions[$i]['Id']);
												if($answers):
                    		for($j = 0; $j < count($answers); $j++):
										?>

										<div class="modal fade" id="updAnswer<?=$i?>_<?=$j?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
											<div class="modal-dialog modal-lg" role="document">
													<div class="modal-content">
															<div class="modal-header">
																		<h5 class="modal-title" id="exampleModalLabel">Редактирование ответа</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
															</div>
															<div class="modal-body">
																	<form action="actions/action_answer.php?method=upd" method="post">
																			<div class="md-form mt-4" style="display: none">
																					<label for="Id">id</label>
																					<input type="text" id="Id" class="form-control" name="Id" value="<?=$answers[$j]['Id']?>" maxlength="20">
																			</div>
																			<div class="md-form mt-4">
																					<label for="Correct">Правильный?</label>
																					<select class="browser-default custom-select" name="Correct">
																							<option <?if($answers[$j]['Correct'] == 1):?>selected<?endif;?>>Да</option>
																							<option <?if($answers[$j]['Correct'] == 0):?>selected<?endif;?>>Нет</option>
																					</select>
																			</div>
																			<div class="md-form mt-4">
																					<label for="value">Текст ответа</label>
																					<textarea name="Text" id="Text" cols="30" rows="3" class="form-control w-100" maxlength="500"><?=base64_decode($answers[$j]['Text'])?></textarea>
																			</div>
																			<div class="text-center mt-4 d-flex justify-content-center">
																					<button type="submit" class="btn btn-primary btn-block btn-rounded z-depth-1a" style="width: 40%;height: 50px;border-radius: 34px">Сохранить</button>
																			</div>
																	</form>
															</div>
															<div class="modal-footer">
																	<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
															</div>
													</div>
											</div>
                		</div>
										<div class="modal fade" id="delAnswer<?=$i?>_<?=$j?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
											<div class="modal-dialog modal-lg" role="document">
													<div class="modal-content">
															<div class="modal-header">
																		<h5 class="modal-title" id="exampleModalLabel">Удаление ответа</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
															</div>
															<div class="modal-body">
																	<form action="actions/action_answer.php?method=del" method="post">
																			<div class="md-form mt-4" style="display: none">
																					<label for="Id">id</label>
																					<input type="text" id="Id" class="form-control" name="Id" value="<?=$answers[$j]['Id']?>" maxlength="20">
																			</div>
																			<h3 class="text-center">Вы действительно хотите удалить ответ "<?=$answers[$j]['Text']?>"?</h3>
																			<div class="text-center mt-4 d-flex justify-content-center">
																					<button type="submit" class="btn btn-danger btn-block btn-rounded z-depth-1a" style="width: 40%;height: 50px;border-radius: 34px">Удалить</button>
																			</div>
																	</form>
															</div>
															<div class="modal-footer">
																	<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
															</div>
													</div>
											</div>
							</div>
										<?endfor;?>


										<table class="table table-striped">
											<thead>
													<tr>
															<th scope="col">#</th>
															<th scope="col">Ответ</th>
															<th scope="col">Правильный?</th>
															<th scope="col">Изменить</th>
															<th scope="col">Удалить</th>
													</tr>
											</thead>
											<tbody>
													<?

														for($j = 0; $j < count($answers); $j++):
													?>
														<tr>
																	<th scope="row">
																			<?=$j + 1?>
																	</th>
																	<td>
																			<?=base64_decode($answers[$j]['Text'])?></td>
																	<td>
																			<?if($answers[$j]['Correct'] == 1):?>Да<?else:?>Нет<?endif;?>
																	</td>
																	<td><a href="#updAnswer<?=$i?>_<?=$j?>" class="btn btn-primary" data-toggle="modal">Изменить</a></td>
																	<td><a href="#delAnswer<?=$i?>_<?=$j?>" class="btn btn-danger" data-toggle="modal">Удалить</a></td>
															</tr>
													<?endfor;?>
														<?else:?>
															<div class="alert border-left-warning alert-dismissible fade show mt-3" role="alert" style="border-left: .25rem solid #f6c23e!important;">
																Добавьте ответы
																<button type="button" class="close" data-dismiss="alert" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																</button>
														</div>
													<?endif;?>
											</tbody>
										</table>
									</div>
										<hr>
								<?endfor;?>
									<?else:?>
									<div class="container">
										<p>Добавьте вопросы</p>
									</div>
								<?endif;?>

							<div class="container mt-5 mb-3">
									<h4>Сообщение после прохождение теста</h4>
									<form action="actions/action_tests.php?method=updRedirect" method="post">
										<div class="md-form mt-4" style="display: none">
												<label for="button_text">id</label>
												<input type="text" id="IdTest" class="form-control" name="IdTest" value="<?=$_GET['IdTest']?>" maxlength="20">
										</div>
										<div class="md-form mt-4">
												<label for="button_text">Ссылка</label>
												<input type="text" min="0" id="Redirect" value="<?=$test['Redirect']?>" class="form-control" name="Redirect" maxlength="20">
										</div>
										<div class="md-form mt-4">
												<label for="TextRedirect">Текст сообщения</label>
												<textarea name="TextRedirect" id="TextRedirect" cols="30" rows="2" class="form-control w-100" maxlength="500"><?=$test['TextRedirect']?></textarea>
										</div>
										<div class="text-center mt-4 d-flex justify-content-center">
												<button type="submit" class="btn btn-primary btn-block btn-rounded z-depth-1a" style="width: 40%;height: 50px;border-radius: 34px">Сохранить</button>
										</div>
									</form>
							</div>

                </div>
            </div>
                    <!-- /.row -->
          </div>
                <!-- /.container-fluid -->
        </div>
			<!-- /.content -->
    </div>

    <!-- Control Sidebar -->
<? include_once '../include/control-sidebar/control-sidebar.php' ?>
<!-- /.control-sidebar -->

    <!-- Main Footer -->
<? include_once '../include/footer/footer.php' ?>
