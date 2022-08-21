import Vue from 'vue';

import Loading from '@/components/elements/loading';
import Attachment from '@/components/elements/attachment';

import InputSwitch from '@/components/forms/input-switch';
import ImageInput from '@/components/forms/image-input';
import InputSelect from '@/components/forms/input-select';
import InputColor from '@/components/forms/input-color';
import InputWysiwyg from '@/components/forms/input-wysiwyg';

Vue.component('loading', Loading);
Vue.component('attachment', Attachment);

Vue.component('input-switch', InputSwitch);
Vue.component('image-input', ImageInput);
Vue.component('input-select', InputSelect);
Vue.component('input-color', InputColor);
Vue.component('input-wysiwyg', InputWysiwyg);

