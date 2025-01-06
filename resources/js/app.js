import 'sweetalert2';

import '@tabler/core/dist/js/tabler.min.js';

import './bootstrap';

// jQuery
import $ from "jquery";

window.$ = $;

import {Livewire} from '../../vendor/livewire/livewire/dist/livewire.esm';

Livewire.start();

import '../../vendor/rappasoft/laravel-livewire-tables/resources/imports/laravel-livewire-tables-all.js';
