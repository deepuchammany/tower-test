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
 * @package Tower
 */

get_header();
?>

	<main id="primary" class="site-main container">

		<?php
		$policies = query_posts( 'post_type=insurance-policy' );
		// print_r($policies);
		echo "<br>";
		?>
		<h2>Insurance Policies</h2>
		<table class="table table-striped">
		<?php
			if(count($policies)>0){
				?>
				<thead>
					<tr>
						<th>Policy ID</th>
						<th>Policy Name</th>
						<th>Policy Description</th>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach($policies as $policy){
					echo "<tr>";
					echo "<td>" . $policy->policy_id . "</td>";
					echo "<td>" . $policy->post_title . "</td>";
					echo "<td>" . $policy->description . "</td>";
					echo "</tr>";
				}
				?>
				</tbody>
				<?php
			}
		?>
		</table>

	</main><!-- #main -->

<?php
// get_sidebar();
get_footer();
