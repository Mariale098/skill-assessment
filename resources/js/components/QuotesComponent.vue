<template>
    <div class="quotes-container">
        <h2>Search Quote by ID:</h2>
        <div class="search-container">
            <input 
                type="number" 
                v-model="searchId" 
                placeholder="Enter quote ID" 
                min="1"
                class="search-input"
                @keyup.enter="searchQuoteById"
            />
            <button @click="searchQuoteById" class="search-button">Search</button>
        </div>

        <div v-if="errorMessage" class="error-message">
            {{ errorMessage }}
        </div>

        <div v-if="searchedQuote" class="quote-card">
            <p>{{ searchedQuote.quote }}</p>
            <p class="author">- {{ searchedQuote.author }}</p>
        </div>

        <h2>Random Quote:</h2>
        <div v-if="randomQuote" class="quote-card">
            <p>{{ randomQuote.quote }}</p>
            <p class="author">- {{ randomQuote.author }}</p>
        </div>

        <h2>Quotes List:</h2>
        <div class="quotes-list">
            <div v-for="quote in quotes" :key="quote.id" class="quote-card">
                <p>{{ quote.quote }}</p>
                <p class="author">- {{ quote.author }}</p>
            </div>
        </div>

        <div class="quotes-pagination">
            <button @click="prevPage" :disabled="skip === 0">Previous</button>
            <button @click="nextPage" :disabled="!hasMore">Next</button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'QuotesComponent',

    data() {
        return {
            randomQuote: null,
            searchedQuote: null,
            searchId: '',
            quotes: [],
            skip: 0,
            limit: 10,
            hasMore: true,
            errorMessage: '',
            isLoading: false
        };
    },

    mounted() {
        this.fetchRandomQuote();
        this.fetchQuotes();
    },

    methods: {
        /**
        * Search for a quote by its ID
        */
        async searchQuoteById() {
            if (!this.searchId) return;
            
            this.isLoading = true;
            this.errorMessage = '';
            
            try {
                const response = await axios.get(`/api/quotes/${this.searchId}`);
                if (Object.keys(response.data).length === 0) {
                    this.errorMessage = 'The quote you are looking for does not exist, please try again.';
                    this.searchedQuote = null;
                    return;
                }
                this.searchedQuote = response.data;
            } catch (error) {
                console.error('Error fetching quote by ID:', error);
                this.searchedQuote = null;
                this.errorMessage = 'An error occurred while searching for the quote. Please try again.';
            } finally {
                this.isLoading = false;
            }
        },

        /**
        * Fetch a random quote from the API
        */
        async fetchRandomQuote() {
            this.isLoading = true;
            this.errorMessage = '';
            
            try {
                const response = await axios.get('/api/quotes/random', {
                    params: {
                        timestamp: Date.now()
                    }
                });
                this.randomQuote = response.data;
            } catch (error) {
                console.error('Error fetching random quote:', error);
                this.errorMessage = 'Error fetching random quote. Please try again.';
            } finally {
                this.isLoading = false;
            }
        },

        /**
        * Fetch paginated quotes from the API
        */
        async fetchQuotes() {
            this.isLoading = true;
            this.errorMessage = '';
            
            try {
                const response = await axios.get(`/api/quotes`, {
                    params: {
                        limit: this.limit,
                        skip: this.skip
                    }
                });
                this.quotes = response.data.quotes;
                this.hasMore = response.data.total > this.skip + this.limit;
            } catch (error) {
                console.error('Error fetching quotes:', error);
                this.errorMessage = 'Error fetching quotes. Please try again.';
            } finally {
                this.isLoading = false;
            }
        },

        /**
        * Go to the next page of quotes
        */
        nextPage() {
            this.skip += this.limit;
            this.fetchQuotes();
        },

        /**
        * Go to the previous page of quotes
        */
        prevPage() {
            this.skip = Math.max(0, this.skip - this.limit);
            this.fetchQuotes();
        }
    }
};
</script> 