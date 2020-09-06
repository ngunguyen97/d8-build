beforeEach(() =>{
  cy.drupalInstall({profile: "standard"});
  cy.drush('en drupal_cypress_twitter');
});

Given(/^the user is authenticated$/, function () {
  cy.drupalSession({user: "admin"});
});

Given(/^the user is viewing the profile$/, function () {
  cy.visit('/user');
  cy.get('.tabs').contains('Edit').click();
});

//When the user enters "@pmelab" into the field labeled "Twitter"
When(/^the user enters "([^"]*)" into the field labeled "([^"]*)"$/, function (value, label) {
  cy.queryByLabelText(label).type(value);
});

//And the user save the profile
And(/^the user save the profile$/, function () {
  cy.queryByText('Save').click();
});

//Then a success message is displayed
Then(/^a success message is displayed$/,function () {
  cy.get('.message').contains('The changes have been saved.');
});
