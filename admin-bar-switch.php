<?php
/*
Plugin Name: Admin Bar Switch
Description: Dodaje przycisk na froncie do ukrywania/pokazywania górnego wp admin bar tylko dla administratora. Stan jest zapamiętywany w pamięci podręcznej. Dodatkowo przycisk lekko wystaje spod paska admina, a po najechaniu pokazuje się cały. Po kliknięciu wystaje spod górnej krawędzi okna.
Version: 1.5
Author: Michał Gąsowski
*/

function abs_add_toggle_button() {
    if ( current_user_can('administrator') ) {
    ?>
        <button id="abs-toggle-button">Admin Bar <span class="abs-icon dashicons dashicons-wordpress-alt"></button>
    <?php
    }
}
add_action('wp_footer', 'abs_add_toggle_button');

function abs_admin_bar_styles() {
    if ( current_user_can('administrator') ) {
        ?>
        <style>
            #abs-toggle-button {
                position: fixed;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: .5rem;
                top: 0;
                right: 1rem;
                width: auto;
                height: 40px;
                background:rgb(255, 255, 255);
                color: #000000;
                font-size: 12px;
                padding: .25rem .5rem;
                border: none;
                box-shadow: 0 0 4px #000;
                cursor: pointer;
                border-radius: 0 0 3px 3px;
                transition: all 0.3s ease;
                z-index: 100;
                opacity: .25
            }
            #abs-toggle-button:hover {
                transform: translateY(32px);
                opacity: 1;
            }
            html.adminbar-hidden #abs-toggle-button {
                top: -32px;
            }
            html.adminbar-hidden #wpadminbar {
                display: none;
            }
            html.adminbar-hidden {
                margin-top: 0 !important;
                transition: all
            }
            .abs-icon {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 16px; /* ustalamy rozmiar ikony */
            }
        </style>
        <?php
    }
}
add_action('wp_head', 'abs_admin_bar_styles');

// Skrypt JavaScript przełączający klasę "hidden" na elemencie <html> i zapisujący stan w localStorage
function abs_toggle_admin_bar_script() {
    if ( current_user_can('administrator') ) {
        ?>
        <script type="text/javascript" async>
            document.addEventListener("DOMContentLoaded", function() {
                var htmlEl = document.documentElement;
                // Odczytaj zapisany stan z localStorage
                var adminBarHidden = localStorage.getItem("adminBarHidden");
                if (adminBarHidden === "true") {
                    htmlEl.classList.add("adminbar-hidden");
                }
                var btn = document.getElementById("abs-toggle-button");
                if (btn) {
                    btn.addEventListener("click", function() {
                        htmlEl.classList.toggle("adminbar-hidden");
                        // Zapisz nowy stan w localStorage
                        localStorage.setItem("adminBarHidden", htmlEl.classList.contains("adminbar-hidden"));
                    });
                }
            });
        </script>
        <?php
    }
}
add_action('wp_footer', 'abs_toggle_admin_bar_script');
?>
