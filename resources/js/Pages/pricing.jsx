import {useEffect} from "react";
import "@src/css/home.css"
import Layout from "@src/js/components/Layout.jsx";

export default function pricing({}) {
    const appURL = window.REACT_APP.APP_URL;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    useEffect(() => {
        document.title = "Pricing";

        const appDiv = document.getElementById('app');
        if (appDiv) {
            appDiv.removeAttribute('data-page');
        }
    }, []);

    return (
        <Layout>
            <div className="container mt-5">
                <h1 className="text-center">Pricing Plan</h1>
                <div className="row mt-4 justify-content-center">
                    <div className="col-lg-4 col-md-6 mb-4">
                        <div className="card border-danger">
                            <div className="card-header text-center">
                                <h4 className="my-0 font-weight-normal">Premium</h4>
                            </div>
                            <div className="card-body text-center">
                                <h1 className="card-title pricing-card-title">$15</h1>
                                <ul className="list-unstyled mt-3 mb-4">
                                    <li>Access to Full Site Features</li>
                                    <li>24/7 Support</li>
                                </ul>
                                <form method="POST" action={appURL + "/pricing"}>
                                    <input type="hidden" name="_token" value={csrfToken} />
                                    <input type="submit" className="btn btn-lg btn-block btn-danger"/>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Layout>
    );
}


