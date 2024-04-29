$(document).ready(function() {
    $('.test-cancel-btn').click(function() {
        var test_reservation_id = $(this).data('test-reservation-id');
        var confirmation = confirm('Are you sure you want to cancel this reservation?');

        if (confirmation) {
            $.ajax({
                url: 'cancel_test_reservation', 
                type: 'POST',
                data: { reservation_id: test_reservation_id },
                success: function(response) {
                    alert('Reservation canceled successfully!');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert('Failed to cancel reservation. Please try again.');
                }
            });
        }
    });

    $('.doc-cancel-btn').click(function() {
        var doc_reservation_id = $(this).data('doc-reservation-id');
        var confirmation = confirm('Are you sure you want to cancel this reservation?');

        if (confirmation) {
            $.ajax({
                url: 'cancel_doc_reservation', 
                type: 'POST',
                data: { reservation_id: doc_reservation_id },
                success: function(response) {
                    alert('Reservation canceled successfully!');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert('Failed to cancel reservation. Please try again.');
                }
            });
        }
    });
});
