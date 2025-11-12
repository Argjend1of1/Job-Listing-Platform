import {InfiniteScroll} from "@inertiajs/react";
import {RotatingLines} from "react-loader-spinner";

const InfiniteScrolling = ({ data, children }) => {
    return(
        <InfiniteScroll data={data}
                        loading={() => <div className={'flex justify-end my-3'}>
                            <RotatingLines
                                visible={true}
                                height="40"
                                width="40"
                                color="grey"
                                strokeWidth="5"
                                animationDuration="0.75"
                                ariaLabel="rotating-lines-loading"
                                wrapperStyle={{}}
                                wrapperClass=""
                            />
                        </div>}
        >
            {children}
        </InfiniteScroll>
    );
}

export default InfiniteScrolling;
