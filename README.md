# WS Coding Challenge

This is a Laravel project that uses Laravel Mix with Vue and TailwindCSS to create a contact page with error handling. Data is sent with XHR, and validated only on the backend.

TailwindCSS & Vue are installed via npm and I have implemented Tailwind's built in purge functionality to optimize the production CSS file.

## Git Workflow

Although not necessary for a small single developer project, I tried to demonstrate the development of key features by splitting them into PRs and merging them. PR's that have more than on commit get squashed with an interactive rebase, and branches are prefixed with `feature`, `enhancement` or `fix`.

## Migrations

Laravel comes with multiple migrations out of the box, so the only one that I use is the `inquiries` migration/table. I added a `jobs` table to test that emails are queued correctly on my local machine.

## Models & Controllers

I only created an Inquiry model and an InquiryController for this project. For a more complex app I would split API traffic into an `Api/InquiryController` controller to keep things separate. In the case of a backoffice application for managing inquiries, those requests would belong in the `InquiryController` instead of `Api/InquiryController`.

## Validation

I validated the post request from the frontend using the `CreateInquiryRequest` request. All fields are validated as requested, however I placed some limitations on the phone field as well. In a real world application, the phone number would have to be validated much more thoroughly as the phone number formats can vary so widely.

## Testing

The `InquiryTest` file container test cases for validation of the inquiry creation. There are tests for multiple expected validation failure points and one test that tests the valid creation and mail queuing of an inquiry.
