<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package TestTheme
 */

get_header();
?>




<div id="page-title">

      <div class="row">

         <div class="ten columns centered text-center">
            <h1>Ваши ставки<span>.</span></h1>

            <p>Здесь отображены все ваши созданные ставки, если нет формы добавления ставки - авторизуйтесь</p>
         </div>

      </div>

   </div> <!-- Page Title End-->

	



<?php if ( is_user_logged_in() ) { ?>

	<div class="form-bet" id="myBet">
	  <form id="addBet" method="post" action="#" class="form-container">
	    <h1>Сделайте ставку!</h1>

	    <label for="login"><b>Заголовок</b></label>
	    <input type="text" class="titleField" placeholder="Заголовок" name="login" required>
	    
	    <label for="pass"><b>Описание</b></label>
	   	<textarea rows="10" cols="45" name="pass" class="descriptField"></textarea>

	   	<label for="sel"><b>Тип ставки</b></label>

	   	<select id="sel">
		  <option>ординар</option>
		  <option>экспресс</option>
		</select>

	    <button type="button" id="btn_addBet" class="btn" value="enter" >Отправить</button>
	  </form>
	</div>

 <? } ?>





   <!-- Content
   ================================================== -->
   <div class="content-outer">

      <div id="page-content" class="row">

         <div id="primary" class="eight columns">



            <?php 

                if(current_user_can('moderator') == true || current_user_can('administrator') == true){

            	if ( have_posts() ) {
            		while (have_posts() ) {
            			the_post(); 
	            			?>
							<article class="post">

				               <div class="entry-header cf">

				               	<h1><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>

				                  <p class="post-meta">

				                     <time class="date" datetime=""><? the_time('F jS, Y') ?></time>


				                  </p>

				               </div>

				               

				               <div class="post-content">

					               	<? the_content(); ?>

				               </div>

			            </article> <!-- post end -->
					
            <?			 
            			

           

					}
				} 
            }
            elseif (current_user_can('caper') == true){
            	if ( have_posts() ) {
            		while (have_posts() ) {
            			the_post(); 
	            		$my_post = get_post( $post->ID ); // $id - ID поста
	            		if ($my_post->post_author == get_current_user_id()) {
	            			
	            			?>
							<article class="post">

				               <div class="entry-header cf">

				               	<h1><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>

				                  <p class="post-meta">

				                     <time class="date" datetime=""><? the_time('F jS, Y') ?></time>


				                  </p>

				               </div>

				               

				               <div class="post-content">

				               	<?

				               	the_content();

				               	?>

				               </div>

			            </article> <!-- post end -->
					
            <?			 
            			
           				}

					}
				} 
            }

            else echo "Войдите на сайт, чтобы иметь возможность добавлять ставки";
            ?>


         </div> <!-- Primary End-->


      </div>

   </div> <!-- Content End-->

			



	

<?php
get_footer();