define([
    'underscore',
    'ko',
    'uiRegistry',
    'Magento_Ui/js/form/element/abstract',
    'jquery',
    'inputMask',
    'mage/url',
    'loader'
], function (_, ko, registry, Abstract, jquery, mask, url) {
    'use strict';

    return Abstract.extend({
        defaults: {
            loading: ko.observable(false),
            imports: {
                update: '${ $.parentName }.country_id:value'
            }
        },

        initialize: function () {
            this._super();
            jquery('#'+this.uid).mask('00000-000', {clearIfNotMatch: true});
            return this;
        },

        /**
         * @param {String} value
         */
        update: function (value) {
            var country = registry.get(this.parentName + '.' + 'country_id'),
                options = country.indexedOptions,
                option;

            if (!value) {
                return;
            }

            if(options[value]){
                option = options[value];

                if (option['is_zipcode_optional']) {
                    this.error(false);
                    this.validation = _.omit(this.validation, 'required-entry');
                } else {
                    this.validation['required-entry'] = true;
                }

                this.required(!option['is_zipcode_optional']);

            }

            this.firstLoad = true;
        },


        onUpdate: function () {
            this.bubble('update', this.hasChanged());
            var validate = this.validate();

            if(validate.valid == true && this.value() && this.value().length == 9){
                /*
                jquery('body').loader('show');

                var element = this;

                var value = this.value();
                value = value.replace('-', '');
                


                jQuery.getJSON("https://viacep.com.br/ws/"+ value +"/json/?callback=?", function(data) {
                    if (!("erro" in data)) {
                        if(registry.get(element.parentName + '.' + 'street.0')){
                            registry.get(element.parentName + '.' + 'street.0').value(data.street ?? '');
                        }
                        if(registry.get(element.parentName + '.' + 'street.2')){
                            registry.get(element.parentName + '.' + 'street.2').value(data.neighborhood ?? '');
                        }
                        if(registry.get(element.parentName + '.' + 'street.3')){
                            registry.get(element.parentName + '.' + 'street.3').value(data.additional_info ?? '');
                        }
                        if(registry.get(element.parentName + '.' + 'city')){
                            registry.get(element.parentName + '.' + 'city').value(data.city ?? '');
                        }
                        if(registry.get(element.parentName + '.' + 'region_id')){
                            registry.get(element.parentName + '.' + 'region_id').value(data.region_id ?? '');
                        }
                        if(registry.get(element.parentName + '.' + 'country_id')){
                            registry.get(element.parentName + '.' + 'country_id').value('BR');
                        }                        
                    } 
                    jQuery('body').loader('hide');
                });
                */
            }
        }
    });
});
