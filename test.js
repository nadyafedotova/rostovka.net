ReactDOM.render(
<BrowserRouter>
<ApolloProvider client={client}>
    <App />
    </ApolloProvider>
    </BrowserRouter>,
document.getElementById('root'),
)