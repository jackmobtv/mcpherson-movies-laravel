import {fullName} from "@src/js/script/helpers.js";

export default function UserHeader({}) {
    const appURL = window.REACT_APP.APP_URL;
    const currentUser = window.REACT_APP.CURRENT_USER;

    return (
        <section className="my-4">
            <div className="container">
                <div className="row">
                    <div className="col-12">
                        <div className="card card-body">
                            <div className="col d-flex justify-content-between align-items-center">
                                <div>
                                    {(currentUser.firstName !== null || currentUser.lastName !== null) &&
                                        <h4>{fullName(currentUser)}</h4>
                                    }
                                </div>
                                <button className="btn btn-primary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
                                    <i className="bi bi-list fs-4"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}


