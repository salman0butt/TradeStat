$(document).ready(function () {

    $('#start_date').datepicker({
        dateFormat: 'yy-mm-dd',
        maxDate: '0'
    });
    $('#end_date').datepicker({
        dateFormat: 'yy-mm-dd',
        maxDate: '0'
    });

    // Client-side form validation
    $('#stock-form').on('submit', function (e) {
        var symbolInput = $('#company_symbol');
        var startDateInput = $('#start_date');
        var endDateInput = $('#end_date');
        var emailInput = $('#email');

        // Remove existing error messages
        $('.error').remove();

        // Validate Company Symbol
        if (symbolInput.val().trim() === '') {
            showError(symbolInput, 'Company Symbol is required');
            e.preventDefault(); // Prevent form submission
        }

        // Validate Start Date
        if (startDateInput.val().trim() === '') {
            showError(startDateInput, 'Start Date is required');
            e.preventDefault(); // Prevent form submission
        }

        // Validate End Date
        if (endDateInput.val().trim() === '') {
            showError(endDateInput, 'End Date is required');
            e.preventDefault(); // Prevent form submission
        }

        // Validate Email
        if (emailInput.val().trim() === '') {
            showError(emailInput, 'Email is required');
            e.preventDefault(); // Prevent form submission
        }

        return true;
    });

    // Helper function to display error message
    function showError(input, message) {
        var errorElement = $('<div class="error">' + message + '</div>');
        input.after(errorElement);
    }

});
