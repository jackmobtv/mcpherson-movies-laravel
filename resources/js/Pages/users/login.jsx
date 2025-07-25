import {useEffect} from "react";
import Layout from "@src/js/components/Layout.jsx";

export default function login() {
    const appURL = window.REACT_APP.APP_URL;

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    useEffect(() => {
        document.title = "Login";
    }, []);

    return (
        <Layout>
            <div className="container col-xl-10 col-xxl-8 px-4 py-5">
                <div className="row align-items-center g-lg-5 py-5">
                    <div className="col-md-10 mx-auto col-lg-5">
                        <form method="post" action={appURL + "/login"}>
                            <input type="hidden" name="_token" value={csrfToken} />

                            <h3 className="mb-3">Please sign in</h3>
                            <div className="form-floating mb-3">
                                <input type="text" className="form-control" id="email" name="email"
                                       placeholder="name@example.com"/>
                                <label htmlFor="email">Email address</label>
                            </div>

                            <div className="form-floating mb-3">
                                <input type="password" className="form-control" id="password" name="password"
                                       placeholder="Password"/>
                                <label htmlFor="password">Password</label>
                            </div>

                            <button className="btn btn-primary w-100 py-2" type="submit">Sign in</button>
                            <p className="mt-5 mb-3 text-body-secondary"><a href={appURL + "/reset-password"}>Forgot password?</a><br/>Don't
                                have an account? <a href="${appURL}/signup">Sign-up</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </Layout>
    );
}
