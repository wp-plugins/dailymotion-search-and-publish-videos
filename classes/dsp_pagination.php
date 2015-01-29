<?php

function dsp_pagination($results, $page, $size, $basequeryurl, $search){
	//PAGINATION Starts here
	echo '<div id="pagination">';
	
	$total = $results;
	$total_pages = ceil( $total / $size );
	
	echo "<strong>Total Records:  " . intval( $total ) . "</strong> | ";
	// 5 pages on the left and 5 pages on the right of current page
	$grace = 5;
	$range = $grace * 2;
	
	$start  = ( $page - $grace ) > 0 ? ( $page - $grace ) : 1;
	$end = $start + $range;
	if( $end > $total_pages ) {
		$end = $total_pages;
		$start = ( $end - $range ) > 0 ? ( $end - $range ) : 1;
	}
	if( $start > 1 ) {
		echo '... <a href="' . esc_url( $basequeryurl ) . '&p=1&search='.esc_html( $search ).'" class="paginator">1</a>....';
	}
	for( $i = $start; $i <= $end; $i++ ) {
		if( $i == $page ) {
		// Current page is not clickable and different from other pages
			echo '<a href="" class="active">' . intval( $i ) . '</a>&nbsp;&nbsp;';		
		} else {
			$url = add_query_arg( 'p', intval( $i ), $basequeryurl.'&search='.esc_html( $search ) );
			echo '<a href="' . esc_url( $url ) . '" class="paginator">' . intval( $i ) . '</a>&nbsp;&nbsp;';
			}
		}
	if( $end < $total_pages ) {
		$url = add_query_arg( 'p', intval( $total_pages ), $total_pages );
		echo '... <a href="' . esc_url( $url ) . '" class="paginator">' . intval( $total_pages ) . '</a>';

		echo '</div>';
		
	}
	//PAGINATION Ends here
}