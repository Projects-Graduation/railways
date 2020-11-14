<?php 
require 'init.php';
// die(var_dump($user));
$page = 'index';
$_SESSION["page"] = "index";
$title = "الرئيسية";
$stations = allStations();
$cities = allCities(null, 4);
?>
<?php include 'includes/layout/header.php'; ?>
    <div class="slide-show">
        <div class="container">
            <div class="col-md-6">
                <form class="search" action="<?= page('travels') ?>" method="GET">
                    <div class="form-group col-md-6">
                        <div class="col-md-12">
                            <label>من</label>
                        </div>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <label for="from_id" class="btn btn-default" type="button"><span class="fa fa-fw fa-map-marker"></span></label>
                            </span>
                            <select name="from_id" id="from_id" class="form-control">
                                <option value="all">الكل</option>
                                <?php foreach(allCities() as $_city):?>
                                    <option value="<?= $_city['id'] ?>"><?= $_city['name'] ?></option>
                                <?php endforeach;?>
                            </select>
                        </div><!-- /input-group -->
                    </div>
                    <div class="form-group col-md-6">
                        <div class="col-md-12"><label>إلى</label></div>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <label for="to_id" class="btn btn-default" type="button"><span class="fa fa-fw fa-map-marker"></span></label>
                            </span>
                            <select name="to_id" id="to_id" class="form-control">
                                <option value="all">الكل</option>
                                <?php foreach(allCities() as $_city):?>
                                    <option value="<?= $_city['id'] ?>"><?= $_city['name'] ?></option>
                                <?php endforeach;?>
                            </select>
                        </div><!-- /input-group -->
                    </div>
                    <div class="form-group col-md-6">
                        <div class="col-md-12">
                            <label>الفئة</label>
                        </div>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <label for="level_id" class="btn btn-default" type="button"><span class="fa fa-fw fa-caret-down"></span></label>
                            </span>
                            <select name="level_id" id="level_id" class="form-control">
                                <option value="all">الكل</option>
                                <?php foreach(allLevels() as $_level):?>
                                    <option value="<?= $_level['id'] ?>"><?= $_level['name'] ?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="col-md-12"><label>تاريخ الإقلاع</label></div>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <label for="datepicker" class="btn btn-default" type="button"><span class="fa fa-fw fa-calendar"></span></label>
                                </span>
                                <input type="date" id="datepicker" name="departure_date" class="form-control datepicker" placeholder="تاريخ الإقلاع">
                            </div><!-- /input-group -->
                        <div class="col-md-12 dest">
                            <!--  -->
                            <!-- <input type="text" class="form-control datepicker" name="departure_date" placeholder="تاريخ الرحلة"> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary btn-block">بحث الرحلات</button>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                </form>
            </div>
            <!-- بداية المستعرض الصور -->
            <div id="features" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <?php for($i = 0; $i < count($stations); $i++):?>
                        <li data-target="#features" data-slide-to="<?= $i ?>" class="<?= $i == 0 ? 'active' : '' ?>"></li>
                    <?php endfor;?>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <?php $counter = 0; foreach($stations as $data): $station = station($data); ?>
                        <div class="item <?= $counter == 0 ? 'active' : '' ?>">
                            <img src="<?= $station['image_url'] ?>" alt="slide-image">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <div class="carousel-caption">
                                    <h3>محطة: <?= $station['name'] ?> مدينة: <?= $station['city_name'] ?></h3>
                                    <p><?= $station['description'] ?></p>
                                </div>
                            </div>
                        </div>
                    <?php $counter++; endforeach;?>
                </div>
        </div>
    </div>
    <div class="features">
        <div class="container">
            <div class="col-md-3">
                <div class="col-md-3 ico"><span class="fa fa-check"></span></div>
                <div class="col-md-9">سبحان الله وبحمده سبحان الله العظيم</div>
            </div>
            <div class="col-md-3">
                <div class="col-md-3 ico"><span class="fa fa-check"></span></div>
                <div class="col-md-9">سبحان الله وبحمده سبحان الله العظيم</div>
            </div>
            <div class="col-md-3">
                <div class="col-md-3 ico"><span class="fa fa-check"></span></div>
                <div class="col-md-9">سبحان الله وبحمده سبحان الله العظيم</div>
            </div>
            <div class="col-md-3">
                <div class="col-md-3 ico"><span class="fa fa-check"></span></div>
                <div class="col-md-9">سبحان الله وبحمده سبحان الله العظيم</div>
            </div>
        </div>
    </div>
    </div>
    <div class="offers clearfix">
        <div class="container">
            <div class="row">
                <div class="col-md-4 reset">
                    <div class="offer">
                        <h4 class="title">افراد العائلة</h4>
                        <p class="description">سوف يتم عمل خصم جزئي قيمته 8% لأفراد العائلة والأصدقاء</p>
                    </div>
                </div>
                <div class="col-md-4 reset">
                    <div class="offer">
                        <h4 class="title">افراد العائلة</h4>
                        <p class="description">سوف يتم عمل خصم جزئي قيمته 8% لأفراد العائلة والأصدقاء</p>
                    </div>
                </div>
                <div class="col-md-4 reset">
                    <div class="offer last">
                        <h4 class="title">افراد العائلة</h4>
                        <p class="description">سوف يتم عمل خصم جزئي قيمته 8% لأفراد العائلة والأصدقاء</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="top-cities">
        <div class="container">
            <h3>المدن الأكثر زيارة</h3>
            <div class="row">
                <?php $counter = 0; foreach($cities as $data): $city = city($data); ?>
                <div class="col-md-3">
                    <a href="<?= page('city') ?>?city_id=<?= $city['id'] ?>">
                        <div class="img-wrapper">
                            <img src="<?= $city['image_url'] ?>" alt="city" class="img inmg-thumbnail img-block img-responsive">
                        </div>
                        <h4><?= $city['name'] ?></h4>
                    </a>
                </div>
                <?php $counter++; endforeach;?>
            </div>
        </div>
    </div>
    <div class="thumbnails">
        <!-- <img src="img/pixel-bus.jpg" alt="bg" class="background"> -->
        <div class="thumbnails-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="thumbnail">
                            <p class="says"><span class="fa fa-fw fa-quote-right"></span>  فكرة جميلة ساعدتني على توفير الكثير من الوقت عند السفر  <span class="fa fa-fw fa-quote-left"></span></p>
                            <div class="person badge">محمد عبدالله</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="thumbnail">
                            <p class="says"><span class="fa fa-fw fa-quote-right"></span>  فكرة جميلة ساعدتني على توفير الكثير من الوقت عند السفر  <span class="fa fa-fw fa-quote-left"></span></p>
                            <div class="person badge">محمد عبدالله</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="thumbnail">
                            <p class="says"><span class="fa fa-fw fa-quote-right"></span>  فكرة جميلة ساعدتني على توفير الكثير من الوقت عند السفر  <span class="fa fa-fw fa-quote-left"></span></p>
                            <div class="person badge">محمد عبدالله</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="thumbnail">
                            <p class="says"><span class="fa fa-fw fa-quote-right"></span>  فكرة جميلة ساعدتني على توفير الكثير من الوقت عند السفر  <span class="fa fa-fw fa-quote-left"></span></p>
                            <div class="person badge">محمد عبدالله</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="thumbnail">
                            <p class="says"><span class="fa fa-fw fa-quote-right"></span>  فكرة جميلة ساعدتني على توفير الكثير من الوقت عند السفر  <span class="fa fa-fw fa-quote-left"></span></p>
                            <div class="person badge">محمد عبدالله</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="thumbnail">
                            <p class="says"><span class="fa fa-fw fa-quote-right"></span>  فكرة جميلة ساعدتني على توفير الكثير من الوقت عند السفر  <span class="fa fa-fw fa-quote-left"></span></p>
                            <div class="person badge">محمد عبدالله</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="social clearfix">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="col-md-5">نشرة الموقع</h5>
                    <div class="col-md-7">
                        <form>
                            <div class="input-group">
                                <input type="text" name="newsletter" placeholder="اكتب البريد اللإلكتروني . . ." class="form-control">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary" type="button">
                                    إشترك
                                    </button>
                                </span>
                            </div><!-- /input-group -->
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="social-network">
                        <p>
                            <h5>حسابات التواصل الإجتماعي:</h5>
                            <span class="sn">
                                <a href="#"><span class="fa fa-fw fa-lg fa-facebook"></span></a>
                            </span>
                            <span class="sn">
                                <a href="#"><span class="fa fa-fw fa-lg fa-twitter"></span></a>
                            </span>
                            <span class="sn">
                                <a href="#"><span class="fa fa-fw fa-lg fa-google-plus"></span></a>
                            </span>
                            <span class="sn">
                                <a href="#"><span class="fa fa-fw fa-lg fa-instagram"></span></a>
                            </span>
                            <span class="sn">
                                <a href="#"><span class="fa fa-fw fa-lg fa-youtube"></span></a>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include 'includes/layout/footer.php'; ?>
