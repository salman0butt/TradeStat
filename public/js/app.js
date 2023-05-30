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
            e.preventDefault();
        }

        // Validate Start Date
        if (startDateInput.val().trim() === '') {
            showError(startDateInput, 'Start Date is required');
            e.preventDefault();
        }

        // Validate End Date
        if (endDateInput.val().trim() === '') {
            showError(endDateInput, 'End Date is required');
            e.preventDefault();
        }

        // Validate Email
        var emailInputValue = emailInput.val().trim();

        if (emailInputValue === '') {
            showError(emailInput, 'Email is required');
            e.preventDefault();
        } else if (!validateEmail(emailInputValue)) {
            showError(emailInput, 'The email must be a valid email address.');
            e.preventDefault();
        }

        return true;
    });

    // Helper function to display error message
    function showError(input, message) {
        var errorElement = $('<div class="error">' + message + '</div>');
        input.after(errorElement);
    }

    // Helper function to validate email format
    function validateEmail(email) {
        var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

});
