/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.btnVerParking').forEach(element => {
        element.addEventListener('click', () => {
            let id = element.getAttribute('data-id');
            fetch('/admin/parking/'+id)
            .then(response => {
                /*if (!response.ok) throw new Error('Error en la respuesta');
                return response.text();*/
            })
            .catch(err => {
                console.error('Error en fetch:', err);
            });
        });
    });
});