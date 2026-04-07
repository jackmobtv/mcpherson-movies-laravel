import {useEffect} from "react";
import "@src/css/home.css"
import Layout from "@src/js/components/Layout.jsx";

export default function about({}) {
    const appURL = window.REACT_APP.APP_URL;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    useEffect(() => {
        document.title = "About";

        const appDiv = document.getElementById('app');
        if (appDiv) {
            appDiv.removeAttribute('data-page');
        }
    }, []);

    return (
        <Layout>
            <div className="container my-5">
                <h1 className="text-center">About Us</h1>
                <div className="row mt-4">
                    <div className="col-lg-6">
                        <h3>Our Mission</h3>
                        <p>This Site is a Database of the Movies I own, This site exists to catalog and manage the
                            collection.</p>
                    </div>
                    <div className="col-lg-6">
                        <h3>Join Us</h3>
                        <p>If you are passionate about movies, feel free to <a href={appURL + "/signup"}>Sign Up</a> for
                            an account.</p>
                    </div>
                </div>

                <div className="row mt-4">
                    <div className="col-lg-6">
                        <h3>Our Features</h3>
                        <ul>
                            <li>Comprehensive Movie and Actor Database</li>
                            <li>Search and filter functionality to find your movies easily</li>
                            <li>User accounts for personalized experiences</li>
                            <li>Community forums for discussion and sharing insights</li>
                        </ul>
                    </div>
                    <div className="col-lg-6">
                        <h3>Premium</h3>
                        <p>For the low price of a Perilous Warp, you can become a <a href={appURL + "/pricing"}>Premium
                            User</a> and Gain Access to the entire site's features.</p>
                    </div>
                </div>
            </div>
        </Layout>
    );
}


