#include <bits/stdc++.h>
#include <iostream> 

using namespace std;


int main() {
  ios_base::sync_with_stdio(false);
  cin.tie(NULL);

  char s[1000];

  for(int i = 0; i < 242383; i++){
  	cin.std::istream::getline (s, 1000);
  	
    for(int j = 0; j < 1000; j++){
      if(s[j] == ';') {
        s[j] ='\0';
        cout << s << endl;
        break;
      }
    }

        
  }

  return 0;
}