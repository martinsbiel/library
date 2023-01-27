import 'vuetify/styles';
import '@mdi/font/css/materialdesignicons.css';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import { VIcon } from 'vuetify/components';
import * as directives from 'vuetify/directives';
import { VBtn } from 'vuetify/components';
import { VTooltip } from 'vuetify/components';
import { VDataTable } from 'vuetify/labs/VDataTable';
import { aliases, mdi } from 'vuetify/iconsets/mdi';

const vuetify = createVuetify({
    components,
    directives,
    components: {
        VDataTable,
        VIcon,
        VBtn,
        VTooltip
    },
    icons: {
        defaultSet: 'mdi',
        aliases,
        sets: {
          mdi
        }
    },
});

export default vuetify;