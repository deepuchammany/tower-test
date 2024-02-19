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
						<th>Live Date</th>
						<th>Policy Description</th>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach($policies as $policy){
					echo "<tr>";
					echo "<td>" . $policy->policy_id . "</td>";
					echo "<td>" . $policy->post_title . "</td>";
					echo "<td>" . $policy->live_date . "</td>";
					echo "<td>" . $policy->description . "</td>";
					echo "</tr>";
				}
				?>
				</tbody>
				<?php
			}
			else{
				echo '<div class="container">No Insurance Policies to display</div>';
			}
		?>
		</table>

		<h2>Insurance Claims</h2>
		<div id="no_claims" class="container" style="display: none;">No Insurance Claims to display</div>
		<table class="table table-striped" id="claims_table" style="display: none;">
			<thead>
				<tr>
					<th>Policy ID</th>
					<th>Name</th>
					<th>Email</th>
				</tr>
			</thead>
			<tbody id="claim-body">
			</tbody>
		</table>

	</main><!-- #main -->

<?php
get_footer();
?>

<script>
	( function ( $ ) {
	$( document ).ready( function () {
        // Fetch insurance claims using Wordpress REST API
		$.ajax({
			type: "GET",
			url: "<?=home_url()?>/wp-json/wp/v2/insurance-claim",
			success: function(results){
				console.log(results);
				if(results.length>0){
					$('#claims_table').show();
				}
				else{
					$('#no_claims').show();
				}
				for(i=0;i<results.length;i++){
					$('#claim-body').append('<tr>\
					<td>'+results[i]['custom'].policy_id+'</td>\
					<td>'+results[i]['title'].rendered+'</td>\
					<td>'+results[i]['custom'].email+'</td>\
					</tr>');
					console.log(results[i]['policy_id']);
				}
			}
		});
	});
}( jQuery ) );
</script>