import validationErrorMessages from "./validationErrorMessages";

export default class ValidateHelper {

    static validateRulesList = {
        required: (value) => !value,
        email: (value) => {
        return !value.match(
                /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            );
        }
    }

    static validateForm(formData, rules, attributeNames) {
        let validationErrors = {};
        for (let attribute in formData) {
            for (let ruleIndex in rules[attribute]) {
                let rule = rules[attribute][ruleIndex];
                if (ValidateHelper.validateRulesList.hasOwnProperty(rule)) {
                    let error = ValidateHelper.validateRulesList[rule](formData[attribute]);
                    if (error) {
                        if (!validationErrors.hasOwnProperty(attribute)) {
                            validationErrors[attribute] = [];
                        }
                        let attributeName = `<b>${attributeNames[attribute]}</b>`;
                        let message = validationErrorMessages[rule].replace(':attribute', attributeName);
                        validationErrors[attribute].push({rule, error, message});
                    }
                }
            }
        }
        return validationErrors;
    }
}
