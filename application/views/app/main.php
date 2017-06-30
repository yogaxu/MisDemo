            <section id="content">
            	<section class="hbox stretch">
                	<section>
                    	<section class="vbox">
                        	<section class="scrollable padder">
                                <div class="row bg-light dk animated fadeInUp">
                                    <div class="col-md-12 dker">
                                        <section><header class="font-bold padder-v">
                                        <div class="pull-right" style="display:none;">
                                            <div class="btn-group">
                                                <button data-toggle="dropdown" class="btn btn-sm btn-rounded btn-default dropdown-toggle"><span class="dropdown-label">2015</span><span class="caret"></span></button>
                                                <ul class="dropdown-menu dropdown-select">
                                                    <li><a href="#"><input type="radio" name="b">2015</a></li>
                                                    <li><a href="#"><input type="radio" name="b">2014</a></li>
                                                    <li><a href="#"><input type="radio" name="b">2013</a></li>
                                                </ul>
                                            </div>
                                            <a href="#" class="btn btn-default btn-icon btn-rounded btn-sm">Go</a>
                                        </div>
                                         年度访问人数报表 </header>
                                        <div class="panel-body">
                                        	<script type="text/javascript">
												var d0 = [
													[1,<?php echo empty($a_vis) ? 0:$a_vis ;?>],
													[2,<?php echo empty($b_vis) ? 0:$b_vis ;?>],
													[3,<?php echo empty($c_vis) ? 0:$c_vis ;?>],
													[4,<?php echo empty($d_vis) ? 0:$d_vis ;?>],
													[5,<?php echo empty($e_vis) ? 0:$e_vis ;?>],
													[6,<?php echo empty($f_vis) ? 0:$f_vis ;?>],
													[7,<?php echo empty($g_vis) ? 0:$g_vis ;?>],
													[8,<?php echo empty($h_vis) ? 0:$h_vis ;?>],
													[9,<?php echo empty($i_vis) ? 0:$i_vis ;?>],
													[10,<?php echo empty($j_vis) ? 0:$j_vis ;?>],
													[11,<?php echo empty($k_vis) ? 0:$k_vis ;?>],
													[12,<?php echo empty($l_vis) ? 0:$l_vis ;?>]
												];
												var d00 = [
													[1,0],[2,1],[3,0],[4,1],[5,0],[6,2],[7,0],[8,3],[9,1],[10,0],[11,1],[12,0]
												];
											</script>
                                            <div id="flot-sp1ine" style="height:300px"></div>
                                        </div>
                                        <div class="row text-center no-gutter">
                                            <div class="col-xs-3">
                                                <span class="h4 font-bold m-t block"><?php echo empty($a_ji_vis) ? 0:$a_ji_vis;?></span><small class="text-muted m-b block">第一季度</small>
                                            </div>
                                            <div class="col-xs-3">
                                                <span class="h4 font-bold m-t block"><?php echo empty($b_ji_vis) ? 0:$b_ji_vis;?></span><small class="text-muted m-b block">第二季度</small>
                                            </div>
                                            <div class="col-xs-3">
                                                <span class="h4 font-bold m-t block"><?php echo empty($c_ji_vis) ? 0:$c_ji_vis;?></span><small class="text-muted m-b block">第三季度</small>
                                            </div>
                                            <div class="col-xs-3">
                                                <span class="h4 font-bold m-t block"><?php echo empty($d_ji_vis) ? 0:$d_ji_vis;?></span><small class="text-muted m-b block">第四季度</small>
                                            </div>
                                        </div>
                                        </section>
                                    </div>
                                </div>
                                <div class="row animated fadeInUp" style="animation-delay:0.3s;-webkit-animation-delay:0.3s;">
                                    <div class="col-sm-12 m-t">
                                        <div class="panel b-a">
                                            <div class="row m-n">
                                                <div class="col-sm-6 col-md-3 b-b b-r">
                                                    <a href="#" class="block padder-v hover">
                                                    	<span class="i-s i-s-2x pull-left m-r-sm">
                                                        	<i class="i i-hexagon2 i-s-base text-primary hover-rotate"></i>
                                                            <i class="i i-cube i-1x text-white"></i>
                                                        </span>
                                                        <span class="clear">
                                                        	<span class="h3 block m-t-xs text-primary time-plus" data-interval="<?php echo interval($product); ?>" data-max="<?php echo $product; ?>" data-step="1">0</span>
                                                            <small class="text-muted text-u-c">产品总数</small>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="col-sm-6 col-md-3 b-b b-r">
                                                    <a href="#" class="block padder-v hover">
                                                    	<span class="i-s i-s-2x pull-left m-r-sm">
                                                        	<i class="i i-hexagon2 i-s-base text-success-lt hover-rotate"></i>
                                                            <i class="i i-health2 i-sm text-white"></i>
                                                        </span>
                                                        <span class="clear">
                                                            <span class="h3 block m-t-xs text-success time-plus" data-interval="<?php echo interval($article); ?>" data-max="<?php echo $article; ?>" data-step="1">0</span>
                                                            <small class="text-muted text-u-c">新闻总数</small>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="col-sm-6 col-md-3 b-b b-r">
                                                    <a href="#" class="block padder-v hover">
                                                        <span class="i-s i-s-2x pull-left m-r-sm">
                                                            <i class="i i-hexagon2 i-s-base text-info hover-rotate"></i>
                                                            <i class="i i-checked i-sm text-white"></i>
                                                        </span>
                                                        <span class="clear">
                                                            <span class="h3 block m-t-xs text-info time-plus" data-interval="<?php echo interval($message); ?>" data-max="<?php echo $message; ?>" data-step="1">0</span>
                                                            <small class="text-muted text-u-c">评论总数</small>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="col-sm-6 col-md-3 b-b">
                                                    <a href="#" class="block padder-v hover">
                                                        <span class="i-s i-s-2x pull-left m-r-sm">
                                                        	<i class="i i-hexagon2 i-s-base text-danger hover-rotate"></i>
                                                        	<i class="i i-alarm i-sm text-white"></i></span>
                                                        <span class="clear">
                                                        	<span class="h3 block m-t-xs text-danger time-plus" data-interval="<?php echo interval($seo['seo_visits']); ?>" data-max="<?php echo $seo['seo_visits']; ?>" data-step="1000">0</span>
                                                        	<small class="text-muted text-u-c">访问总次数</small>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                	<div class="col-md-4 animated fadeInUp" style="animation-delay:0.6s;-webkit-animation-delay:0.6s;">
                                    	<section class="panel"> 
                                        	<header class="panel-heading b-b"> <span class="badge pull-right">news</span>新会员注册率 </header>
                                            <?php $v_baifb = 100 / 100 * $v_today; ?> 
                                            <div class="panel-body text-center"> 
                                                <div class="inline"> 
                                                    <div class="easypiechart" data-percent="<?php echo empty($v_baifb) ? 0:$v_baifb ;?>" data-bar-color="#fcc633" data-line-width="16" data-loop="false" data-size="188" data-animate="3000"> 
                                                    	<div> <span class="h2 m-l-sm step"><?php echo empty($v_baifb) ? 0:$v_baifb ;?></span>% <div class="text text-sm">注册率</div> </div> 
                                                    </div> 
                                                </div> 
                                                <div class="row text-center m-t-lg m-b-md"> 
                                                	<div class="col-xs-6"> 
                                                    	<p>昨天</p> 
                                                    	<h3 class="font-thin"><?php echo empty($v_yesterday) ? 0:$v_yesterday ;?></h3> 
                                                    </div> 
                                                    <div class="col-xs-6"> 
                                                    	<p>今天</p> 
                                                    	<h3 class="font-thin"><?php echo empty($v_today) ? 0:$v_today ;?></h3> 
                                                    </div> 
                                                </div>
                                            </div> 
                                        </section> 
									</div>
                                    <div class="col-md-4 animated fadeInUp" style="animation-delay:0.9s;-webkit-animation-delay:0.9s;">
                                    	<section class="panel"> 
                                        	<header class="panel-heading b-b"> <span class="badge pull-right">news</span>新闻评论率 </header>
                                            <?php $m_baifb = 100 / 100 * $m_today; ?>
                                            <div class="panel-body text-center"> 
                                                <div class="inline"> 
                                                    <div class="easypiechart" data-percent="<?php echo empty($m_baifb) ? 0:$m_baifb ;?>" data-bar-color="#64b9cd" data-line-width="16" data-loop="false" data-size="188" data-animate="3000"> 
                                                    	<div> <span class="h2 m-l-sm step"><?php echo empty($m_baifb) ? 0:$m_baifb ;?></span>% <div class="text text-sm">评论率</div> </div> 
                                                    </div> 
                                                </div>
                                                <div class="row text-center m-t-lg m-b-md"> 
                                                	<div class="col-xs-6"> 
                                                    	<p>昨天</p> 
                                                    	<h3 class="font-thin"><?php echo empty($m_yesterday) ? 0:$m_yesterday ;?></h3> 
                                                    </div> 
                                                    <div class="col-xs-6"> 
                                                    	<p>今天</p> 
                                                    	<h3 class="font-thin"><?php echo empty($m_today) ? 0:$m_today ;?></h3> 
                                                    </div> 
                                                </div> 
                                            </div> 
                                        </section> 
									</div>
                                    <div class="col-md-4">
                                    	<section class="panel animated fadeInUp" style="animation-delay:1.2s;-webkit-animation-delay:1.2s;">
                                        	<header class="panel-heading b-b"> 当天的访问率 </header>
                                            <?php $baifb = 100 / 100 * $today; ?>
                                            <div class="panel-body text-center"> 
                                                <div class="inline"> 
                                                    <div class="easypiechart" data-percent="<?php echo empty($baifb) ? 0:$baifb ;?>" data-bar-color="#fcc633" data-line-width="16" data-loop="false" data-size="188" data-animate="3000"> 
                                                    	<div> <span class="h2 m-l-sm step"><?php echo empty($baifb) ? 0:$baifb ;?></span>% <div class="text text-sm">访问率</div> </div> 
                                                    </div> 
                                                </div>
                                                <div class="row text-center m-t-lg m-b-md"> 
                                                	<div class="col-xs-6"> 
                                                    	<p>昨天</p> 
                                                    	<h3 class="font-thin"><?php echo empty($yesterday) ? 0:$yesterday ;?></h3> 
                                                    </div> 
                                                    <div class="col-xs-6"> 
                                                    	<p>今天</p> 
                                                    	<h3 class="font-thin"><?php echo empty($today) ? 0:$today ;?></h3> 
                                                    </div> 
                                                </div> 
                                            </div> 
                                        </section>
									</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                    	<div class="list-group bg-default auto hidden-xs animated fadeInUp" style="animation-delay:1.5s;-webkit-animation-delay:1.5s;">
                                            <a href="#" class="list-group-item"> 服务器版本信息 </a>
                                            <a href="#" class="list-group-item"> <span class="badge"><?php echo $_SERVER['SERVER_NAME'];?> (port:<?php echo $_SERVER['SERVER_PORT'];?>)</span> <i class="fa fa-foursquare icon-muted fa-fw"></i> 网站域名 </a>
                                            <a href="#" class="list-group-item"> <span class="badge"><?php echo $_SERVER['SERVER_SOFTWARE'];?></span> <i class="fa fa-foursquare icon-muted fa-fw"></i> WEB服务器 </a>
                                            <a href="#" class="list-group-item"> <span class="badge"><?php echo PHP_OS; ?></span> <i class="fa fa-foursquare icon-muted fa-fw"></i> 操作系统 </a>
                                            <a href="#" class="list-group-item"> <span class="badge"><?php echo mysql_get_server_info(); ?></span> <i class="fa fa-foursquare icon-muted fa-fw"></i> 数据库版本 </a>
                                            <a href="#" class="list-group-item"> <span class="badge"><?php echo PHP_VERSION; ?></span> <i class="fa fa-foursquare icon-muted fa-fw"></i> PHP版本 </a>
                                            <a href="#" class="list-group-item"> <span class="badge">3.0</span> <i class="fa fa-foursquare icon-muted fa-fw"></i> 当前系统版本 </a>
                                            <a href="#" class="list-group-item"> <span class="badge">UTF - 8</span> <i class="fa fa-foursquare icon-muted fa-fw"></i> 语言编码 </a>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-8">
                                    <section class="panel panel-default animated fadeInUp" style="animation-delay:1.8s;-webkit-animation-delay:1.8s;">
                                            <header class="panel-heading">当前服务器状态</header>
                                            <div class="panel-body">
                                                <div id="flot-live" style="height:255px"></div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                    		</section>
                    	</section>
                    </section>
            	</section>
                <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
			</section>
	
 