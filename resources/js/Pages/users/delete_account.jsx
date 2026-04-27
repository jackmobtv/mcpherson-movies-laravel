import {useEffect} from "react";
import "@src/css/home.css"
import Layout from "@src/js/components/Layout.jsx";
import UserSidebar from "@src/js/components/UserSidebar.jsx";
import UserHeader from "@src/js/components/UserHeader.jsx";

export default function delete_account({}) {
    const appURL = window.REACT_APP.APP_URL;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    useEffect(() => {
        document.title = "Delete Account";

        const appDiv = document.getElementById('app');
        if (appDiv) {
            appDiv.removeAttribute('data-page');
        }
    }, []);

    return (
        <Layout>
            <main>
                <UserHeader/>

                <section className="pt-0">
                    <div className="container">
                        <div className="row">
                            <UserSidebar/>

                            <div className="col-xl-9">
                                <div className="card border bg-transparent rounded-3 mb-0">
                                    <div className="card-header bg-transparent border-bottom">
                                        <h3 className="card-header-title mb-0">Delete Account</h3>
                                    </div>
                                    <div className="card-body">
                                        <h6>If you delete your account, you will lose your all data.</h6>
                                        <form method="POST" action={appURL + "/delete-account"}>
                                            <input type="hidden" name="_token" value={csrfToken} />
                                            <div className="col-md-6 my-4">
                                                <label className="form-label" htmlFor="email">Email</label>
                                                <input className="form-control" type="text" id="email" name="email"/>
                                            </div>
                                            <div className="col-md-6 my-4">
                                                <label className="form-label" htmlFor="password">Password</label>
                                                <input className="form-control" type="password" id="password" name="password"/>
                                            </div>

                                            <button type="submit" className="btn btn-danger mb-0">Delete my account</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </Layout>
    );
}


