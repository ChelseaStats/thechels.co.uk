<?php /* Template Name: # Z ** Replace */ ?>
<?php get_header();?>
<?php if (current_user_can('level_10')) : ?>
    <div id="content">
    <div id="contentleft">
        <?php print $go->goAdminMenu(); ?>
        <h4 class="special"> <?php the_title(); ?></h4>
<?php
$offset =0; // Setting Offset Value For String.
if(isset($_POST['text' ]) 
    && isset($_POST['searchfor' ]) && isset($_POST['replacewith' ]))
{
$text =$_POST['text' ]; //Getting Text Area Value In Which String Is Entered
$search = $_POST['searchfor' ]; // Getting String To Be Searched
$replace =$_POST['replacewith' ];// Getting String To Be Replace with 
$search_length = strlen($search);// Getting String length

if(!empty($text)&&!empty($search)&&!empty($replace)) 
//Checking Value is Empty or Not
{
while($strpos = strpos($text,$search,$offset)) 
//Finding The Search String With While Loop
{
$offset = $strpos + $search_length;//Changing Offset value
$text = substr_replace($text, $replace,$strpos,$search_length);
// Here String is Replaced
}
$text=stripslashes($text);
echo '<pre>'.$text.'</pre>';
}
else
{
echo'Please fill in all fields.' ;
}
}
?>
<form action="<?php the_permalink();?>" method="POST">
    
        <div class="form-group">
        <textarea name="text" rows="10" cols="250" class="form-control" > </textarea>
        </div>
    
        <div class="form-group">
        <label for="searchfor">Search for:</label>
        <input type="text" name="searchfor" class="form-control"><br/>
        </div>

        <div class="form-group">
        <label for="replacewith">Replace with:</label>
        <input type="text" name="replacewith" class="form-control"><br/>
        </div>
    
    
        <div class="form-group">
        <input type="submit" value="Find and Replace" class="btn btn-primary">
        </div>

</form>
    </div>
        <?php get_template_part('sidebar');?>
    </div>
    <div class="clearfix"><p>&nbsp;</p></div>
    <!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
