import {useEffect} from "react";
import "@src/css/home.css"
import Layout from "@src/js/components/Layout.jsx";

export default function terms({}) {
    const appURL = window.REACT_APP.APP_URL;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    useEffect(() => {
        document.title = "Terms of Service";

        const appDiv = document.getElementById('app');
        if (appDiv) {
            appDiv.removeAttribute('data-page');
        }
    }, []);

    return (
        <Layout>
            <div className="container my-5">
                <h1 className="text-center">Terms of Service</h1>
                <p className="lead text-center">Last updated: April 2025</p>

                <h2>1. Acceptance of Terms</h2>
                <p>By accessing and using the Movie Database, you agree to comply with and be bound by these Terms of
                    Service.</p>

                <h2>2. User Accounts</h2>
                <p>You may need to create an account to use certain features of the Movie Database. You are responsible
                    for maintaining the confidentiality of your account credentials and for all activities that occur
                    under your account.</p>

                <h2>3. Content Ownership</h2>
                <p>All content available on the Movie Database, including but not limited to movies, descriptions,
                    images, and reviews, is protected by copyright and intellectual property laws.</p>

                <h2>4. Restrictions</h2>
                <p>You agree not to use the Movie Database for any unlawful purpose or in violation of applicable laws
                    and regulations.</p>

                <h2>5. Limitation of Liability</h2>
                <p>The Movie Database is not liable for any direct, indirect, incidental, or consequential damages
                    arising out of your use or inability to use the service.</p>

                <h2>6. Changes to the Terms</h2>
                <p>We may update these Terms of Service from time to time. Your continued use of the service after
                    changes are made constitutes your acceptance of the new Terms.</p>
            </div>
        </Layout>
    );
}


