import template from './sw-category-entry-point-overwrite-modal.html.twig';
import './sw-category-entry-point-overwrite-modal.scss';

/**
 * @package inventory
 */
// eslint-disable-next-line sw-deprecation-rules/private-feature-declarations
export default {
    template,

    compatConfig: Shopware.compatConfig,

    emits: [
        'cancel',
        'confirm',
    ],

    props: {
        salesChannels: {
            type: Array,
            required: false,
            default: () => {
                return [];
            },
        },
    },

    methods: {
        onCancel() {
            this.$emit('cancel');
        },

        onConfirm() {
            this.$emit('confirm');
        },
    },
};
